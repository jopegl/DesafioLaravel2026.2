<footer class="bg-gray-800 text-white mt-auto">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex flex-col md:flex-row justify-between items-center">
            <div class="text-sm">
                &copy; {{ date('Y') }} EmporiO. Todos os direitos reservados.
            </div>

            <div class="flex space-x-6 mt-4 md:mt-0 text-sm">
                <a href="{{ route('home') }}" class="hover:underline">Início</a>
                <a href="#" class=" hover:underline">Contato</a>
                <a href="#" class="hover:underline">Categorias</a>
            </div>
        </div>
    </div>
</footer>