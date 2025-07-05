<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Board;
use App\Models\BoardHasUser;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreBoardRequest;
use App\Http\Requests\UpdateBoardRequest;
use App\Http\Requests\AddUserToBoardRequest;

class BoardController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search', '');
        $perPage = $request->input('perPage', 9);

        try{
            $boards = Board::where('user_id', auth()->user()->id)
            ->where('name', 'like', '%' . $search . '%')
            ->orWhere(DB::raw('id IN (SELECT board_id FROM board_has_users WHERE user_id = ' . auth()->user()->id . ')'), true)
            ->where('name', 'like', '%' . $search . '%')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

        return response()->json($boards, 200);
    }

    public function show($id)
    {
        try {
            $board = Board::find($id);
            $board->load('user');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Board não encontrado');
        }

        return view('app.board.show', compact('board'));
    }

    public function store(StoreBoardRequest $request)
    {
        try{
            $board = Board::create([
                'name' => $request->name,
                'description' => $request->description,
                'user_id' => auth()->user()->id,
            ]);
            $board->load('user');
            return response()->json($board);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

        return response()->json(['error' => 'Erro ao criar board'], 500);
    }

    public function destroy($id)
    {
        $board = Board::find($id);

        if (!$board) {
            return response()->json(['error' => 'Board não encontrado'], 404);
        }

        $board->columns()->each(function ($column) {
            $column->cards()->delete();
            $column->delete();
        });

        $board->delete();
        return response()->json(['message' => 'Board deletado com sucesso']);
    }

    public function update(UpdateBoardRequest $request, $id)
    {
        try{
            $board = Board::find($id);
            $board->update($request->all());
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

        return response()->json($board, 200);
    }

    public function getBoardUsers($id)
    {
        $board = Board::find($id);
        $board->load('users');

        return response()->json($board->users, 200);
    }

    public function removeUserFromBoard($id, $userId)
    {
        $validator = Validator::make(['userId' => $userId, 'boardId' => $id], [
            'userId' => 'required|exists:users,id|not_in:' . auth()->user()->id,
            'boardId' => 'required|exists:boards,id',
        ], [
            'userId.required' => 'O ID do usuário é obrigatório',
            'userId.exists' => 'O ID do usuário não existe',
            'userId.not_in' => 'Você não pode remover a si mesmo do board',
            'boardId.required' => 'O ID do board é obrigatório',
            'boardId.exists' => 'O ID do board não existe',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $board = Board::find($id);
        $user = User::find($userId);
        
        
        try{
            $boardHasUser = BoardHasUser::where('board_id', $board->id)->where('user_id', $user->id)->first();
            $boardHasUser->delete();

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

        return response()->json(['message' => 'Usuário removido do board com sucesso'], 200);
    }

    public function addUserToBoard(AddUserToBoardRequest $request)
    {
        $board = Board::find($request->board_id);
        $user = User::where('email', $request->email)->first();

        if ($board->users()->where('user_id', $user->id)->exists()) {
            return response()->json(['error' => ['email' => ['Usuário já está adicionado ao board']]], 422);
        }

        $board->users()->attach($user->id);

        return response()->json(['message' => 'Usuário adicionado ao board com sucesso'], 200);
    }
}
