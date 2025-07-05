<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Column;
use App\Models\Board;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreColumnRequest;
use App\Http\Requests\UpdateColumnRequest;

class ColumnController extends Controller
{
    public function index($boardId)
    {
        $columns = Board::find($boardId)->columns()->orderBy('position', 'asc')->get();

        if(!$columns){
            return response()->json(['error' => 'Colunas não encontradas'], 404);
        }

        try{
            $columns->load(['cards' => function($query) {
                $query->orderBy('position', 'asc');
                $query->with('assignedUser');
            }]);
        }catch(\Exception $e){
            return response()->json(['error' => 'Erro ao carregar colunas'], 500);
        }

        return response()->json($columns, 200);
    }

    public function store(StoreColumnRequest $request)
    {
        $board = Board::find($request->board_id);

        if(!$board){
            return response()->json(['error' => 'Quadro não encontrado'], 404);
        }

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
        $column = Column::find($id);

        if(!$column){
            return response()->json(['error' => 'Coluna não encontrada'], 404);
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

    public function update(UpdateColumnRequest $request, $id)
    {
        $column = Column::find($id);

        if(!$column){
            return response()->json(['error' => 'Coluna não encontrada'], 422);
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
