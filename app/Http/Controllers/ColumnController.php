<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Column;
use App\Models\Board;
use Illuminate\Support\Facades\Validator;

class ColumnController extends Controller
{
    public function index($boardId)
    {
        $columns = Board::find($boardId)->columns()->orderBy('position', 'asc')->get();

        $columns->load(['cards' => function($query) {
            $query->orderBy('position', 'asc');
            $query->with('assignedUser');
        }]);

        return response()->json($columns, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'color' => 'required|string|max:255',
            'board_id' => 'required|exists:boards,id',
        ], [
            'name.required' => 'O nome da coluna é obrigatório',
            'name.string' => 'O nome da coluna deve ser uma string',
            'name.max' => 'O nome da coluna deve ter no máximo 255 caracteres',
            'color.required' => 'A cor da coluna é obrigatória',
            'color.string' => 'A cor da coluna deve ser uma string',
            'color.max' => 'A cor da coluna deve ter no máximo 255 caracteres',
            'board_id.required' => 'O ID do quadro é obrigatório',
            'board_id.exists' => 'O ID do quadro não existe',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $board = Board::find($request->board_id);

        try{
            $board->columns()->create([
                'name' => $request->name,
                'color' => $request->color,
                'position' => $board->columns->count() + 1,
            ]);
        }catch(\Exception $e){
            return response()->json(['error' => 'Erro ao adicionar coluna'], 500);
        }

        return response()->json(['message' => 'Coluna adicionada com sucesso'], 201);
    }

    public function destroy($id)
    {
        $column = Column::find($id);

        if(!$column){
            return response()->json(['error' => 'Coluna não encontrada'], 404);
        }

        $column->cards()->each(function ($card) {
            $card->delete();
        });

        $column->delete();

        return response()->json(['message' => 'Coluna deletada com sucesso'], 200);
    }

    public function move(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'position' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        try{
            $column = Column::find($id);
            $boardId = $column->board_id;
            $originalColumnInPosition = Column::where('board_id', $boardId)->where('position', $request->position)->first();
    
            if($originalColumnInPosition){
                $originalColumnInPosition->update([
                    'position' => $column->position,
                ]);
            }

            $column->update([
                'position' => $request->position,
            ]);
        }catch(\Exception $e){
            return response()->json(['error' => 'Erro ao mover coluna'], 500);
        }

        return response()->json(['message' => 'Coluna movida com sucesso'], 200);
    }

    public function update(Request $request, $id)
    {
        $column = Column::find($id);

        if(!$column){
            return response()->json(['error' => 'Coluna não encontrada'], 422);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'color' => 'required|string|max:255',
        ], [
            'name.required' => 'O nome da coluna é obrigatório',
            'name.string' => 'O nome da coluna deve ser uma string',
            'name.max' => 'O nome da coluna deve ter no máximo 255 caracteres',
            'color.required' => 'A cor da coluna é obrigatória',
            'color.string' => 'A cor da coluna deve ser uma string',
            'color.max' => 'A cor da coluna deve ter no máximo 255 caracteres',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        try{
            $column->update([
                'name' => $request->name,
                'color' => $request->color,
            ]);
        }catch(\Exception $e){
            return response()->json(['error' => 'Erro ao atualizar coluna'], 500);
        }

        return response()->json(['message' => 'Coluna atualizada com sucesso'], 200);
    }
}
