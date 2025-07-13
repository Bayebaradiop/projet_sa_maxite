<main class="flex-1 p-8">
                <!-- Filters -->
                <div class="mb-6 flex space-x-4">
                    <div class="relative">
                        <input type="date" name="date-filter" class="bg-white border border-gray-300 rounded-lg px-4 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-maxitsa-orange focus:border-transparent">
                    </div>
                    
                    <div class="relative">
                        <select name="type-filter" class="bg-white border border-gray-300 rounded-lg px-4 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-maxitsa-orange focus:border-transparent">
                            <option value="">Type</option>
                            <option value="depot">Depot</option>
                            <option value="retrait">Retrait</option>
                            <option value="paiement">Paiement</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                
                <!-- Transaction Table -->
                <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="text-left py-3 px-6 font-medium text-gray-700">Date</th>
                                <th class="text-left py-3 px-6 font-medium text-gray-700">Type</th>
                              <th class="text-left py-3 px-6 font-medium text-gray-700">Description</th>
                                <th class="text-left py-3 px-6 font-medium text-gray-700">Amount</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
    <?php foreach ($transactions as $transaction): ?>
        <tr class="hover:bg-gray-50">
            <td class="py-4 px-6 text-gray-600"><?= htmlspecialchars($transaction->getDate()->format('d/m/Y')) ?></td>
            <td class="py-4 px-6">
                <span class="px-2 py-1 
                    <?= $transaction->getTypeTransaction()->value === 'depot' ? 'bg-green-100 text-green-800' : 
                        ($transaction->getTypeTransaction()->value === 'retrait' ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800') ?>
                    text-xs font-medium rounded">
                    <?= htmlspecialchars(ucfirst($transaction->getTypeTransaction()->value)) ?>
                </span>
            </td>
            <td class="py-4 px-6 text-gray-600">
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
            </td>
            <td class="py-4 px-6 <?= $transaction->getMontant() < 0 ? 'text-red-600' : 'text-green-600' ?> font-medium">
                <?= $transaction->getMontant() < 0 ? '' : '+' ?><?= number_format(abs($transaction->getMontant()), 0, ',', ' ') ?> CFA
            </td>
        </tr>
    <?php endforeach; ?>
</tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="mt-6 flex justify-center">
                    <nav class="flex items-center space-x-2">
                        <button class="px-3 py-2 text-gray-500 hover:text-gray-700">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                        <button class="px-3 py-2 bg-maxitsa-orange text-white rounded font-medium">1</button>
                        <button class="px-3 py-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded">2</button>
                        <button class="px-3 py-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded">3</button>
                        <button class="px-3 py-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded">4</button>
                        <button class="px-3 py-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded">5</button>
                        <button class="px-3 py-2 text-gray-500 hover:text-gray-700">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </nav>
                </div>
            </main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const dateInput = document.querySelector('input[name="date-filter"]');
    const typeSelect = document.querySelector('select[name="type-filter"]');
    const rows = document.querySelectorAll('tbody tr');

    function filterRows() {
        const dateValue = dateInput.value;
        const typeValue = typeSelect.value.toLowerCase();

        rows.forEach(row => {
            let show = true;

            // Filtre par type strict (depot, retrait, paiement)
            if (typeValue !== '') {
                const typeCell = row.querySelector('td:nth-child(2) span');
                const cellType = typeCell ? typeCell.textContent.trim().toLowerCase() : '';
                if (!['depot', 'retrait', 'paiement'].includes(cellType) || cellType !== typeValue) {
                    show = false;
                }
            }

            // Filtre par date exacte
            if (dateValue !== '') {
                const dateCell = row.querySelector('td:nth-child(1)');
                if (dateCell) {
                    // Format attendu : d/m/Y
                    const [day, month, year] = dateCell.textContent.trim().split('/');
                    const rowDate = `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`;
                    if (rowDate !== dateValue) {
                        show = false;
                    }
                }
            }

            row.style.display = show ? '' : 'none';
        });
    }

    dateInput.addEventListener('change', filterRows);
    typeSelect.addEventListener('change', filterRows);
});
</script>