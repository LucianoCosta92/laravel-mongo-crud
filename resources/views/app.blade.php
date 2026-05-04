<x-layout.app-layout title="TaskManager">

    {{-- ── Página de login ── --}}
    <x-views.login />

    {{-- ── Aplicação principal (visível após autenticação) ── --}}
    <div id="page-app" class="hidden">

        <x-layout.sidebar />

        <div class="main">
            <x-layout.topbar />

            <div class="content">
                <x-views.dashboard />
                <x-views.tasks />
                <x-views.categories />
            </div>
        </div>

    </div>

    {{-- ── Modais globais ── --}}
    <x-modals.modal-register />
    <x-modals.modal-task />
    <x-modals.modal-category />

</x-layout.app-layout>
