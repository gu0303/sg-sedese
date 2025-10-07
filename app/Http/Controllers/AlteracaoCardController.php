<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AlteracaoCard;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AlteracaoCardController extends Controller
{
    // Exibe as alterações em cards
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = AlteracaoCard::with('user')->orderBy('created_at', 'desc');

        if ($search) {
                $isDateBr = preg_match('/\d{2}\/\d{2}\/\d{4}/', $search);

                $date = null;

                if ($isDateBr) {
                    try {
                        $date = \Carbon\Carbon::createFromFormat('d/m/Y H:i', $search)->format('Y-m-d H:i');
                    } catch (\Exception $e) {
                        try {
                            $date = \Carbon\Carbon::createFromFormat('d/m/Y', $search)->format('Y-m-d');
                        } catch (\Exception $e2) {
                            $date = null;
                        }
                    }
                }

                $query->where(function ($q) use ($search, $isDateBr, $date) {
                    $q->where('descricao', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($u) use ($search) {
                        $u->where('name', 'like', "%{$search}%");
                    });

                    // Se for uma data no formato BR válida, também busca pelos campos de data
                    if ($isDateBr && $date) {
                        $q->orWhere('created_at', 'like', "%{$date}%")
                        ->orWhere('updated_at', 'like', "%{$date}%");
                    }
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
