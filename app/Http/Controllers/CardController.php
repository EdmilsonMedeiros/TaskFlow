<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Column;
use App\Models\Card;
use App\Http\Requests\StoreCardRequest;
use App\Http\Requests\UpdateCardRequest;
use App\Http\Requests\MoveCardRequest;

class CardController extends Controller
{
    public function store(StoreCardRequest $request)
    {
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
        $card->load(['assignedUser', 'column']);
        return response()->json($card, 200);
    }

    public function update(UpdateCardRequest $request, $id)
    {
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

    public function move(MoveCardRequest $request, $id)
    {
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
            
            $card->load('column');
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao avançar task'], 500);
        }

        return response()->json($card, 200);
    }

    public function cardPrevious(Request $request, $id)
    {
        $card = Card::find($id);
        $actualColumn = Column::find($card->column_id);
        $previousColumn = Column::where('board_id', $actualColumn->board_id)->where('position', $actualColumn->position - 1)->first();

        if (!$previousColumn) {
            return response()->json(['message' => 'Não há mais colunas para retroceder'], 400);
        }

        try{
            $card->update([
                'column_id' => $previousColumn->id,
            ]);
            
            $card->load('column');
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao retroceder task'], 500);
        }

        return response()->json($card, 200);
    }
}
