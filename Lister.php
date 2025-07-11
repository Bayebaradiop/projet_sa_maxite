<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ges Auchan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }
    </style>
</head>
<body class="bg-gray-900 text-white">
    <header class="bg-gray-800 border-b border-gray-700">
        <div class="px-6 py-4">
            <nav class="flex items-center justify-between">
                <div class="flex items-center space-x-8">
                    <div class="flex items-center space-x-2">
                        <div class="w-6 h-6 bg-green-500 rounded"></div>
                        <span class="text-lg font-medium">Ges Auchan</span>
                    </div>
                    <div class="hidden md:flex space-x-6">
                        <a href="#" class="text-white font-medium">Commandes</a>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <button class="p-2 text-gray-400 hover:text-white transition-colors">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zM8 6a2 2 0 114 0v1H8V6z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                    <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                        <span class="text-sm font-medium text-white">V</span>
                    </div>
                </div>
            </nav>
        </div>
    </header>

    <main class="p-6">
        <div class="max-w-7xl mx-auto">
            <h1 class="text-2xl font-bold mb-6">Liste des commandes</h1>
            
            <div class="flex justify-center gap-4 mb-6">
                <div class="relative">
                    <select class="bg-gray-800 border border-gray-600 rounded-lg px-4 py-2 pr-8 text-white focus:outline-none focus:border-green-500">
                        <option>Filtrer par statut</option>
                        <option>Impayé</option>
                        <option>Payé</option>
                        <option>En cours</option>
                    </select>
                    <div class="absolute right-3 top-1/2 transform -translate-y-1/2 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                </div>
                
                <div class="relative">
                    <select class="bg-gray-800 border border-gray-600 rounded-lg px-4 py-2 pr-8 text-white focus:outline-none focus:border-green-500">
                        <option>Filtrer par client</option>
                        <option>BAKARY DIASSY</option>
                        <option>ANONYME</option>
                        <option>AU DIOP</option>
                    </select>
                    <div class="absolute right-3 top-1/2 transform -translate-y-1/2 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                </div>
                
                <div class="relative">
                    <select class="bg-gray-800 border border-gray-600 rounded-lg px-4 py-2 pr-8 text-white focus:outline-none focus:border-green-500">
                        <option>Filtrer par État</option>
                        <option>Actif</option>
                        <option>Inactif</option>
                    </select>
                    <div class="absolute right-3 top-1/2 transform -translate-y-1/2 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                </div>

                <div class="relative">
                    <a href="form.html.php" class="bg-green-600 p-2">
                    <a href="PasserCommande.php" class="bg-green-600 p-2"> Passer Une Commande</a>
                    </a>
                </div>
            </div>

            <div class="bg-gray-800 rounded-lg overflow-hidden">
                <table class="w-full">
                    <thead class="bg-gray-700 border-b border-gray-600">
                        <tr>
                            <th class="text-left py-4 px-6 font-medium text-gray-300">Numéro Commande</th>
                            <th class="text-left py-4 px-6 font-medium text-gray-300">Client</th>
                            <th class="text-left py-4 px-6 font-medium text-gray-300">Statut</th>
                            <th class="text-left py-4 px-6 font-medium text-gray-300">Facture</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700">
                        <tr class="hover:bg-gray-750 transition-colors">
                            <td class="py-4 px-6 text-white">#COM_001</td>
                            <td class="py-4 px-6 text-white">BAKARY DIASSY</td>
                            <td class="py-4 px-6">
                                <span class="px-3 py-1 bg-red-900 text-red-200 rounded-full text-sm">Impayé</span>
                            </td>
                            <td class="py-4 px-6">
                                
                                <button class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors">
                                    voir
                                </button>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-750 transition-colors">
                            <td class="py-4 px-6 text-white">#COM_002</td>
                            <td class="py-4 px-6 text-white">ANONYME</td>
                            <td class="py-4 px-6">
                                <span class="px-3 py-1 bg-red-900 text-red-200 rounded-full text-sm">Impayé</span>
                            </td>
                            <td class="py-4 px-6">
                                <button class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors">
                                    voir
                                </button>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-750 transition-colors">
                            <td class="py-4 px-6 text-white">#COM_003</td>
                            <td class="py-4 px-6 text-white">AU DIOP</td>
                            <td class="py-4 px-6">
                                <span class="px-3 py-1 bg-red-900 text-red-200 rounded-full text-sm">Impayé</span>
                            </td>
                            <td class="py-4 px-6">
                                <button class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors">
                                    voir
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="flex justify-center mt-6">
                <nav class="flex items-center space-x-2">
                    <button class="p-2 text-gray-400 hover:text-white transition-colors">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                    <button class="w-8 h-8 bg-green-600 text-white rounded-full flex items-center justify-center font-medium">
                        1
                    </button>
                    <button class="w-8 h-8 text-gray-400 hover:text-white transition-colors rounded-full flex items-center justify-center">
                        2
                    </button>
                    <button class="w-8 h-8 text-gray-400 hover:text-white transition-colors rounded-full flex items-center justify-center">
                        3
                    </button>
                    <button class="p-2 text-gray-400 hover:text-white transition-colors">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </nav>
            </div>
        </div>
    </main>


</body>
</html>
