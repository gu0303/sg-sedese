<?php

namespace App\Http\Controllers;

use App\Models\AlteracaoCard;
use Illuminate\Http\Request;
use App\Models\PlanilhaItem;
use Illuminate\Support\Facades\Auth;

class PlanilhaController extends Controller
{
    // Campos com labels (todos os campos)
    private $fields = [
        'nome_sistema' => 'Nome do Sistema',
        'ip' => 'IP',
        'ambiente' => 'Ambiente',
        'url' => 'URL',
        'tipo_os' => 'Tipo do Sistema Operacional',
        'usuario_os' => 'Usuário do Sistema Operacional',
        'senha_os' => 'Senha do Sistema Operacional',
        'usuario_site' => 'Usuário da Aplicação',
        'senha_site' => 'Senha da Aplicação',
        'database' => 'Nome do Banco',
        'usuario_db' => 'Usuário Database',
        'senha_db' =>  'Senha Database',
        'caminho' => 'Caminho da Aplicação',
        'git' =>  'Repositório git',
        'empresa_desenvolvdor' => 'Empresa/Desenvolvedor',
        'responsavel_diretor' => 'Responsavel/Diretor'
    ];

    // Campos que aparecem na planilha (visíveis)
    private $visibleFields = [
        'nome_sistema' => 'Nome do Sistema',
        'ip' => 'IP',
        'ambiente' => 'Ambiente',
        'url' => 'URL',
    ];

    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = PlanilhaItem::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                foreach (array_keys($this->fields) as $field) {
                    $q->orWhere($field, 'like', "%{$search}%");
                }
            });
        }

        $planilhaItens = $query->get();

        return view('planilha.planilha', [
            'planilhaItens' => $planilhaItens,
            'columns' => $this->visibleFields,
            'labels' => $this->fields,
        ]);
    }

    public function create()
    {
        return view('planilha.add_item', [
            'fields' => $this->fields,
        ]);
    }

    public function store(Request $request)
    {
        $rules = [];
        foreach (array_keys($this->fields) as $field) {
            if ($field === 'ambiente') {
                $rules[$field] = 'nullable|in:Produção,Homologação,Desenvolvimento';
            } else {
                $rules[$field] = 'nullable|string|max:255';
            }
        }

        $validated = $request->validate($rules);

        PlanilhaItem::create($validated);

        return redirect()->route('planilha.index')->with('success', 'Item adicionado com sucesso!');
    }

    public function edit($id)
    {
        $item = PlanilhaItem::findOrFail($id);

        return view('planilha.edit', [
            'item' => $item,
            'fields' => $this->fields,
        ]);
    }

    public function update(Request $request, $id)
    {
        $item = PlanilhaItem::findOrFail($id);

        $rules = [];
        foreach (array_keys($this->fields) as $field) {
            if ($field === 'ambiente') {
                $rules[$field] = 'nullable|in:Produção,Homologação,Desenvolvimento';
            } else {
                $rules[$field] = 'nullable|string|max:255';
            }
        }

        $validated = $request->validate($rules);

        $item->update($validated);

        return redirect()->route('planilha.index')->with('success', 'Item atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $item = PlanilhaItem::findOrFail($id);
        $item->delete();

        return redirect()->route('planilha.index')->with('success', 'Item removido com sucesso!');
    }

    public function updatePlanilhaItem(Request $request, $id)
    {
        $planilhaItem = PlanilhaItem::findOrFail($id);

        $oldValues = $planilhaItem->only(array_keys($this->fields));
        $newValues = $request->only(array_keys($this->fields));

        $changed = false;
        $descricao = "Alteração no campo: ";
        $vazio = "Campo vazio";

        $planilhaItem->update($newValues);

        foreach ($oldValues as $field => $oldValue) {
            $newValue = $planilhaItem->$field;

            if ($oldValue != $newValue) {
                $changed = true;
                $label = $this->fields[$field] ?? $field;

                $oldFormatted = (trim($oldValue) === '') ? $vazio : e($oldValue);
                $newFormatted = (trim($newValue) === '') ? $vazio : e($newValue);

                $descricao .= "{$label} de '{$oldFormatted}' para '{$newFormatted}'. ";
            }
        }

        if ($changed) {
            AlteracaoCard::create([
                'user_id' => Auth::id(),
                'descricao' => $descricao,
            ]);
        }

        return redirect()->route('planilha.index')->with('success', 'Planilha atualizada com sucesso!');
    }
}
