@extends('layouts.master')

@section('subtitle', 'Itens da planilha')
@section('content_header_title', 'Itens da planilha')
{{-- @section('content_header_subtitle', 'Aqui estão os itens cadastrados') --}}

@section('content_body')
    <div class="container">
        <div class="col-12">

            {{-- Sobre --}}
            <div class="card card-dark collapsed-card">
                <div class="card-header">
                    <h3 class="card-title">Sobre</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Expandir">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body" style="display: none;">
                    <p>Aqui estão armazenados dados de: ip, sistema operacional, usuário, senha, entre outros.</p>
                </div>
            </div>

            {{-- Tabela com os itens --}}
            <div class="card card-dark">
                <div class="card-header">
                    <h3 class="card-title">Sistemas SEDESE</h3>
                </div>
                <div class="card-body">
                    {{-- Pesquisa de itens --}}
                    <form method="GET" action="{{ route('planilha.index') }}">
                        <div class="input-group custom-input-group mb-3">
                            <input type="text" name="search" value="{{ request('search') }}"
                                class="form-control form-control-sm" placeholder="Pesquisar campos">
                            <button type="submit" class="btn btn-secondary btn-sm ml-1">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>

                    {{-- Mensagem de sucesso --}}
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <div class="table-responsive" style="overflow-y: auto; max-height: 600px;">
                        <table class="table table-bordered mt-3">
                            <thead class="thead-light">
                                <tr>
                                    <th style="text-align: center;">Ações</th>
                                    @foreach ($columns as $column => $label)
                                        <th>{{ $label }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($planilhaItens as $item)
                                    <tr>
                                        <td>
                                            <div class="d-flex">
                                                <a href="{{ route('planilha.edit', $item->id) }}"
                                                    class="btn btn-primary btn-sm mr-2">Editar</a>
                                                <form action="{{ route('planilha.destroy', $item->id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger btn-sm"
                                                        onclick="return confirm('Tem certeza que deseja esse sistema?')">Remover</button>
                                                </form>
                                                <button type="button" class="btn btn-warning btn-sm ml-2"
                                                    data-item='@json($item)'
                                                    onclick="mostrarPopupData(this)">Exibir</button>
                                            </div>
                                        </td>
                                        @foreach ($columns as $column => $label)
                                            <td>{{ $item->$column }}</td>
                                        @endforeach
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="{{ count($columns) + 1 }}">Nenhum item encontrado.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Link para adicionar um novo item --}}
                    <div class="d-flex mt-3">
                        <a href="{{ route('planilha.add_item') }}" class="btn btn-success mr-2">Adicionar Novo Item</a>
                        <a href="{{ route('home') }}" class="btn btn-secondary">Home</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Popup --}}
    <div class="modal fade" id="itemDetalhesModal" tabindex="-1" role="dialog" aria-labelledby="itemDetalhesLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detalhes do Item</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <ul id="listaDetalhes" style="list-style-type: none; padding-left: 0;"></ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        function mostrarPopupData(button) {
            const item = JSON.parse(button.getAttribute('data-item'));
            mostrarPopup(item);
        }

        function mostrarPopup(item) {
            const lista = document.getElementById('listaDetalhes');
            lista.innerHTML = '';

            const campos = {
                'Nome do Sistema': item.nome_sistema,
                'IP': item.ip,
                'Ambiente': item.ambiente,
                'URL': item.url,
                'Tipo do Sistema Operacional': item.tipo_os,
                'Usuário do Sistema Operacional': item.usuario_os,
                'Senha do Sistema Operacional': item.senha_os,
                'Usuário de Acesso ao Site': item.usuario_site,
                'Senha de Acesso ao Site': item.senha_site,
                'Database': item.database,
                'Usuário Database':item.usuario_db,
                'Senha Database':item.senha_db,
                'Caminho':item.caminho,
                'Repositório git':item.git,
                'Empresa/Desenvolvedor':item.empresa_desenvolvedor,
                'Responsavel/Diretor':item.responsavel_diretor
            };

            for (const [chave, valor] of Object.entries(campos)) {
                const li = document.createElement('li');
                li.innerHTML = `<strong>${chave}:</strong> ${valor ? valor : ''}`;
                lista.appendChild(li);
            }

            $('#itemDetalhesModal').modal('show');
        }
    </script>
@endpush
