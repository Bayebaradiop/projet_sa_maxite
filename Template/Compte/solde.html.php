<div class="max-w-7xl mx-auto">
    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-lg card-shadow hover-lift">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Solde principal</p>
                    <p class="text-2xl font-bold text-gray-900">
                        <?php echo number_format($comptes[0]->getSolde(), 0, ',', ' ') . ' CFA'; ?>
                    </p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <!-- ...svg... -->
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg card-shadow hover-lift">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Numero Telephone</p>
                    <p class="text-2xl font-bold text-gray-900">
                        <?php echo htmlspecialchars($comptes[0]->getNumeroTel()); ?>
                    </p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <!-- ...svg... -->
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg card-shadow hover-lift">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Transactions ce mois</p>
                    <p class="text-2xl font-bold text-gray-900">
                        <?php echo count($comptes[0]->getTransactions() ?? []); ?>
                    </p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <!-- ...svg... -->
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg card-shadow hover-lift mb-8">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Informations du compte</h3>
        </div>
        <div class="p-6">
            <div class="flex items-center justify-between">
                <div class="flex">
                    <div class="w-16 h-16 bg-gradient-to-r from-primary to-primary-dark rounded-full flex  ">
                        <span class="text-white font-bold text-lg">
                            <?php echo strtoupper(substr($comptes[0]->getUser()->getNom(), 0, 1) . substr($comptes[0]->getUser()->getPrenom(), 0, 1)); ?>
                        </span>
                    </div>
                    <div>
                        <h4 class="text-xl font-semibold text-gray-900">
                            <?php echo htmlspecialchars($comptes[0]->getUser()->getNom() . ' ' . $comptes[0]->getUser()->getPrenom()); ?>
                        </h4>
                        <p class="text-gray-600">Numéro de compte: <?php echo htmlspecialchars($comptes[0]->getNumero()); ?></p>
                        <div class="flex items-center mt-2 ">
                            <span class="text-sm text-gray-500">Solde actuel:</span>
                            <span class="text-lg font-bold text-primary">
                                <?php echo number_format($comptes[0]->getSolde(), 0, ',', ' ') . ' CFA'; ?>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="flex space-x-3">
                    <button class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary-dark transition-colors">
                        Virement
                    </button>
                    <button class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                        Historique
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>