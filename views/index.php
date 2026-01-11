<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sistema de Diário de Classes</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .carousel-slide {
            min-width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .carousel-title {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
        }

        .carousel-subtitle {
            font-size: 1.25rem;
            color: #333;
        }
    </style>
</head>
<body class="bg-gray-100">

<header class="bg-gray-800 text-white py-4">
    <div class="container mx-auto flex justify-between items-center px-4">
        <!-- Informações à esquerda -->
        <div>
            <h1 class="text-3xl font-bold">Sistema de Diário de Classes</h1>
            <p class="text-sm text-gray-400">Organize suas aulas, registros de frequência e avaliações</p>
        </div>

        <!-- Botões de Cadastro e Login à direita -->
        <div class="space-x-4">
            <a href="login.php" class="px-4 py-2 bg-blue-200 text-gray-800 rounded-lg hover:bg-blue-300">Login</a>
            <a href="register.php" class="px-4 py-2 bg-blue-200 text-gray-800 rounded-lg hover:bg-blue-300">Cadastro</a>
        </div>
    </div>
</header>

<!-- Container do carrossel -->
<div class="relative w-full h-96 mx-auto overflow-hidden bg-white shadow-md">
    <!-- Slides -->
    <div class="flex h-full transition-transform duration-500 ease-in-out" id="carousel">
        <!-- Slide 1 -->
        <div class="carousel-slide bg-blue-200 p-8">
            <h2 class="carousel-title">Controle Total da Sua Turma</h2>
            <p class="carousel-subtitle">Com o Sistema de Diário de Classes, mantenha registros organizados <br> e acesse todas as informações da sua turma em um só lugar.</p>
        </div>
        <!-- Slide 2 -->
        <div class="carousel-slide bg-green-200 p-8">
            <h2 class="carousel-title">Fácil Acesso e Relatórios</h2>
            <p class="carousel-subtitle">Visualize a frequência e o desempenho dos alunos a qualquer momento. <br> Gere relatórios completos com apenas alguns cliques.</p>
        </div>
        <!-- Slide 3 -->
        <div class="carousel-slide bg-red-200 p-8">
            <h2 class="carousel-title">Planejamento Eficiente</h2>
            <p class="carousel-subtitle">Defina suas aulas com antecedência e registre o progresso dos alunos <br> em tempo real, garantindo uma gestão impecável.</p>
        </div>
        <!-- Slide 4 -->
        <div class="carousel-slide bg-yellow-200 p-8">
            <h2 class="carousel-title">Sistema Seguro e Confiável</h2>
            <p class="carousel-subtitle">Segurança é a nossa prioridade. Todos os seus dados estão protegidos <br> com os mais altos padrões de segurança.</p>
        </div>
    </div>

    <!-- Controles do carrossel (bolinhas) -->
    <div class="absolute bottom-4 left-0 right-0 flex justify-center space-x-4">
        <button class="w-4 h-4 bg-gray-800 rounded-full" id="prevBtn"></button>
        <button class="w-4 h-4 bg-gray-800 rounded-full" id="nextBtn"></button>
    </div>
</div>

<div class="container mx-auto px-4 py-10">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Card 1 -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-2xl font-bold mb-2">Registro de Frequência</h2>
            <p class="text-gray-600 mb-4">Registre e acompanhe a presença dos alunos em cada aula de forma simples e rápida. Gere relatórios detalhados e mantenha o controle de quem está participando.</p>
            <button class="px-4 py-2 bg-blue-200 text-gray-800 rounded-md hover:bg-blue-300">Saiba mais</button>
        </div>

        <!-- Card 2 -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-2xl font-bold mb-2">Planejamento de Aulas</h2>
            <p class="text-gray-600 mb-4">Organize seu calendário de aulas com facilidade. Defina temas, horários e atribua atividades diretamente no sistema, garantindo uma gestão eficiente.</p>
            <button class="px-4 py-2 bg-green-200 text-gray-800 rounded-md hover:bg-green-300">Ver detalhes</button>
        </div>

        <!-- Card 3 -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-2xl font-bold mb-2">Relatórios de Desempenho</h2>
            <p class="text-gray-600 mb-4">Gere relatórios de notas e frequência dos alunos para acompanhamento em tempo real. Visualize o progresso dos alunos ao longo do ano letivo.</p>
            <button class="px-4 py-2 bg-yellow-200 text-gray-800 rounded-md hover:bg-yellow-300">Explore</button>
        </div>
    </div>
</div>

<!-- Seção de Depoimentos -->
<section class="bg-gray-100 py-5">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-3xl font-bold mb-5">O que nossos usuários estão dizendo</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Depoimento 1 -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <p class="text-gray-600 italic mb-4">"Este sistema simplificou muito o meu trabalho como professor. Agora consigo gerenciar a frequência e o desempenho dos alunos de forma muito mais eficiente."</p>
                <p class="font-bold text-gray-800">- Prof. João Silva</p>
                <p class="text-sm text-gray-500">Escola Estadual ABC</p>
            </div>

            <!-- Depoimento 2 -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <p class="text-gray-600 italic mb-4">"As funcionalidades de planejamento e relatórios me ajudaram a acompanhar o progresso dos alunos ao longo do ano letivo. Recomendo fortemente!"</p>
                <p class="font-bold text-gray-800">- Profa. Maria Oliveira</p>
                <p class="text-sm text-gray-500">Colégio XYZ</p>
            </div>

            <!-- Depoimento 3 -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <p class="text-gray-600 italic mb-4">"O Sistema de Diário de Classes tornou tudo mais prático e acessível. Agora tenho mais tempo para focar no ensino e menos em burocracias."</p>
                <p class="font-bold text-gray-800">- Prof. Pedro Costa</p>
                <p class="text-sm text-gray-500">Instituto Educar</p>
            </div>
        </div>
    </div>
</section>

<footer class="bg-gray-800 text-white py-4 mt-10">
    <div class="container mx-auto text-center space-y-2">
        <p class="text-sm text-gray-400">© 2024 Sistema de Diário de Classes - Todos os direitos reservados.</p>
        <p class="text-xs text-gray-500">Dica: A regularidade dos registros de aulas facilita o acompanhamento da aprendizagem dos alunos.</p>
        <div class="flex justify-center space-x-4 mt-4">
            <a href="https://github.com/delacerdaq" target="_blank" class="text-blue-400 hover:text-blue-600 text-sm">
                GitHub - Ana Lacerda
            </a>
            <a href="https://github.com/ababue" target="_blank" class="text-blue-400 hover:text-blue-600 text-sm">
                GitHub - Gabriel Batista
            </a>
            <a href="https://github.com/Yuri-Stiwart1" target="_blank" class="text-blue-400 hover:text-blue-600 text-sm">
                GitHub - Yuri Stiwart
            </a>
        </div>
    </div>
</footer>


<script>
    const carousel = document.getElementById('carousel');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    let index = 0;

    function updateCarousel() {
        const width = carousel.clientWidth;
        carousel.style.transform = `translateX(-${index * width}px)`;
    }

    nextBtn.addEventListener('click', () => {
        index = (index + 1) % 4; // Alterado para 4 slides
        updateCarousel();
    });

    prevBtn.addEventListener('click', () => {
        index = (index - 1 + 4) % 4; // Alterado para 4 slides
        updateCarousel();
    });

    window.addEventListener('resize', updateCarousel);
</script>

</body>
</html>
