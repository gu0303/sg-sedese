<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AlteracaoCard;
use Illuminate\Support\Facades\Auth;

class AlteracaoCardController extends Controller
{
    // Exibe as alterações em cards
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = AlteracaoCard::with('user')->orderBy('created_at', 'desc');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('descricao', 'like', "%{$search}%")
                ->orWhere('created_at', 'like', "%{$search}%")
                ->orWhere('updated_at', 'like', "%{$search}%")
                ->orWhereHas('user', function ($u) use ($search) {
                $u->where('name', 'like', "%{$search}%");
          });
        });
        }

        $alteracoes = $query->get();

        return view('posts.posts', compact('alteracoes'));
    }

    // Salva um novo card de alteração
    public function storeCard(Request $request)
    {
        // Verificar se a descrição não está vazia
        if (empty($request->descricao)) {
            return redirect()->back()->with('info', 'Nenhuma alteração foi feita.');
        }

        // Caso contrário, salva o card
        $card = new AlteracaoCard();
        $card->user_id = Auth::id(); // ID do usuário logado
        $card->descricao = $request->descricao; // Descrição da alteração
        $card->save();

        return redirect()->back()->with('success', 'Alteração registrada com sucesso!');
    }

    // Exibe o formulário para editar o card
    public function editCard($id)
    {
        $card = AlteracaoCard::findOrFail($id);
        return view('posts.editCard', compact('card'));
    }

    // Atualiza a descrição de um card
    public function updateCard(Request $request, $id)
    {
        $card = AlteracaoCard::findOrFail($id);
        $card->descricao = $request->descricao;
        $card->save();

        return redirect()->route('posts.index')->with('success', 'Descrição atualizada com sucesso!');
    }

    // Remove um card
    public function destroyCard($id)
    {
        $card = AlteracaoCard::findOrFail($id);
        $card->delete();

        return redirect()->back()->with('success', 'Alteração removida com sucesso!');
    }
}
