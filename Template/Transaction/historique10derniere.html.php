<div class="flex h-screen">
    <div class="flex-1 p-8">
        <div class="grid grid-cols-5 gap-4 mb-8">
            <div class="card-pattern-black bg-gradient-to-br from-orange-500 to-orange-400 rounded-2xl h-20 shadow-lg"></div>
            <div class="card-pattern bg-gradient-to-br from-orange-500 to-orange-400 rounded-2xl h-20 shadow-lg"></div>
            <div class="card-pattern-black bg-gradient-to-br from-gray-900 to-gray-800 rounded-2xl h-20 shadow-lg"></div>
            <div class="card-pattern bg-gradient-to-br from-orange-500 to-orange-400 rounded-2xl h-20 shadow-lg"></div>
            <div class="card-pattern-black bg-gradient-to-br from-gray-900 to-gray-800 rounded-2xl h-20 shadow-lg"></div>
        </div>
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-blue-50 border-b">
                            <th class="text-left p-4 font-semibold text-gray-700">Date</th>
                            <th class="text-left p-4 font-semibold text-gray-700">Type</th>
                            <th class="text-left p-4 font-semibold text-gray-700">Description</th>
                            <th class="text-left p-4 font-semibold text-gray-700">Solde</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($transactions as $transaction): ?>
                            <tr class="transaction-row transition-all duration-200 ease-in-out hover:bg-blue-50 hover:-translate-y-0.5 border-b">
                                <td class="p-4 text-gray-600"><?= htmlspecialchars($transaction->getDate()->format('d/m/Y')) ?></td>
                                <td class="p-4">
                                    <?php
                                    $type = $transaction->getTypeTransaction()->value;
                                    $typeClasses = [
                                        'Depot' => 'bg-green-100 text-green-800',
                                        'Retrait' => 'bg-red-100 text-red-800',
                                        'Transfert' => 'bg-blue-100 text-blue-800',
                                        'Payment' => 'bg-yellow-100 text-yellow-800'
                                    ];
                                    $classes = $typeClasses[$type] ?? 'bg-gray-100 text-gray-800';
                                    ?>
                                    <span class="<?= $classes ?> px-3 py-1 rounded-full text-sm font-medium"><?= htmlspecialchars($type) ?></span>
                                </td>
                                <td class="p-4 text-gray-600">
                                    <div class="flex items-center">
                                        <div class="status-indicator w-2 h-2 rounded-full bg-green-500 mr-2"></div>
                                        <?php
                                        $type = strtolower($transaction->getTypeTransaction()->value);
                                        if ($type === 'depot') {
                                            $desc = "Dépôt sur le compte principal";
                                        } elseif ($type === 'retrait') {
                                            $desc = "Retrait effectué";
                                        } elseif ($type === 'paiement') {
                                            $desc = "Paiement d'un service";
                                        } else {
                                            $desc = "Transaction";
                                        }
                                        ?>
                                        <?= htmlspecialchars($desc) ?>
                                    </div>
                                </td>
                                <td class="p-4 <?= $transaction->getMontant() < 0 ? 'text-red-600' : 'text-green-600' ?> font-semibold">
                                    <?= $transaction->getMontant() < 0 ? '' : '+' ?><?= number_format(abs($transaction->getMontant()), 0, ',', ' ') ?> CFA
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="bg-gray-50 p-4 flex justify-between items-center">
                <a  href="/afficheTOusLesTransactions" class="bg-pink-500 hover:bg-pink-600 text-white px-4 py-2 rounded-lg transition-colors duration-200">
                    Voir plus
                </a>
                <div class="text-sm text-gray-500">
                    <span class="bg-blue-500 text-white px-3 py-1 rounded">
                        Du 08 au 15/07
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>