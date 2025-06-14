<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Column;
use App\Models\Card;

class CardController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'column_id' => 'required|exists:columns,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $column = Column::find($request->column_id);

        try{
            $column->cards()->create([
                'title' => $request->title,
                'position' => $column->cards()->count() + 1,
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao criar task'], 500);
        }

        return response()->json($column);
    }

    public function get(Request $request, $id)
    {
        $card = Card::find($id);
        $card->load('assignedUser');
        return response()->json($card, 200);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'assigned_user_id' => 'nullable|exists:users,id',
        ], [
            'title.required' => 'O título da task é obrigatório',
            'title.string' => 'O título da task deve ser uma string',
            'title.max' => 'O título da task deve ter no máximo 255 caracteres',
            'description.string' => 'A descrição da task deve ser uma string',
            'assigned_user_id.exists' => 'O membro selecionado não existe',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $card = Card::find($id);

        try{
            $card->update($request->all());
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao atualizar task'], 500);
        }

        return response()->json($card, 200);
    }

    public function destroy(Request $request, $id)
    {
        $card = Card::find($id);

        try{
            $card->delete();
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao deletar task'], 500);
        }

        return response()->json(['message' => 'Task deletada com sucesso'], 200);
    }

    public function move(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'column_id' => 'required|exists:columns,id',
            'position' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $card = Card::find($id);
        
        try{
            $card->update([
                'column_id' => $request->column_id,
                'position' => $request->position,
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao mover task'], 500);
        }

        return response()->json($card, 200);
    }

    public function myCards()
    {
        $cards = \App\Models\Card::where('assigned_user_id', auth()->user()->id)
            ->with('column')
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();

        return response()->json($cards, 200);
    }

    public function cardNext(Request $request, $id)
    {
        $card = Card::find($id);
        $actualColumn = Column::find($card->column_id);
        $nextColumn = Column::where('board_id', $actualColumn->board_id)->where('position', $actualColumn->position + 1)->first();

        if (!$nextColumn) {
            return response()->json(['message' => 'Não há mais colunas para avançar'], 400);
        }

        try{
            $card->update([
                'column_id' => $nextColumn->id,
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao avançar task'], 500);
        }

        return response()->json($card, 200);
    }
}
