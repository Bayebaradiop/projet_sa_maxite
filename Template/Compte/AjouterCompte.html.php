<?php
$errors = $_SESSION['errors'] ?? [];
$openPopup = $_SESSION['openPopup'] ?? false;

unset($_SESSION['errors'], $_SESSION['openPopup']);
?>

<main class="flex-1 p-8">
    <div class="grid grid-cols-5 gap-6 mb-8">
        <!-- Account Card 1 -->
        <div class="bg-gray-900 rounded-2xl p-6 text-white">
            <div class="mb-4">
                <p class="text-gray-400 text-sm mb-2">Numéro Téléphonique</p>
                <p class="text-white font-medium">
                    <?php echo htmlspecialchars($comptes->getNumeroTel()); ?>

                </p>
            </div>
        </div>

        <!-- Account Card 2 -->
        <div class="bg-maxitsa-orange rounded-2xl p-6 text-white">
            <div class="mb-4">
                <p class="text-orange-200 text-sm mb-2">Numéro de Compte</p>
                <p class="text-white font-medium">
                    <?php echo htmlspecialchars($comptes->getNumero()); ?>
                </p>
            </div>
        </div>

        <!-- Account Card 3 -->
        <div class="bg-gray-900 rounded-2xl p-6 text-white">
            <div class="mb-4">
                <p class="text-gray-400 text-sm mb-2">Solde</p>
                <p class="text-white font-medium">
                    <?php echo htmlspecialchars($comptes->getSolde()); ?> CFA


                </p>
            </div>
        </div>

        <!-- Account Card 4 -->
        <div class="bg-maxitsa-orange rounded-2xl p-6 text-white">
            <div class="mb-4">
                <p class="text-orange-200 text-sm mb-2">Type de Compte</p>
                <p class="text-white font-medium">Principal</p>
            </div>
        </div>

        <!-- Account Card 5 -->
        <div class="bg-gray-900 rounded-2xl p-6 text-white">
            <div class="mb-4">
                <p class="text-gray-400 text-sm mb-2">Date de creation</p>
                <p class="text-white font-medium">
                    -
                </p>
            </div>
        </div>
    </div>

    <!-- Secondary Accounts Table -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Comptes Secondaires</h3>
                    <p class="text-sm text-gray-600 mt-1">Liste de tous vos comptes secondaires</p>
                </div>
                <button class="px-4 py-2 bg-maxitsa-orange text-white rounded-lg hover:bg-orange-600 transition-colors">
                    Créer nouveau compte
                </button>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="text-left py-3 px-6 font-medium text-gray-700">Numéro de Compte</th>
                        <th class="text-left py-3 px-6 font-medium text-gray-700">Numéro Téléphonique</th>
                        <th class="text-left py-3 px-6 font-medium text-gray-700">Solde</th>
                        <th class="text-left py-3 px-6 font-medium text-gray-700">Type</th>
                        <th class="text-left py-3 px-6 font-medium text-gray-700">Date de Création</th>
                        <th class="text-left py-3 px-6 font-medium text-gray-700"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php foreach ($comptesSecondaires as $compte): ?>
                    <tr class="hover:bg-gray-50">
                        <td class="py-4 px-6 text-gray-900 font-medium">
                            <?php echo htmlspecialchars($compte->getNumero()); ?>
                        </td>
                        <td class="py-4 px-6 text-gray-600">
                            <?php echo htmlspecialchars($compte->getNumeroTel()); ?>
                        </td>
                        <td class="py-4 px-6 text-gray-900 font-medium">
                            <?php echo htmlspecialchars($compte->getSolde()); ?> CFA
                        </td>
                        <td class="py-4 px-6">
                            <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs font-medium rounded">
                                Secondaire
                            </span>
                        </td>
                        <td class="py-4 px-6 text-gray-600">
                            <?php echo htmlspecialchars($compte->getDateCreation()->format('d/m/Y')); ?>
                        </td>
                        <td class="py-4 px-6">
                            <form method="post" action="/changerComptePrincipal" style="display:inline;">
                                <input type="hidden" name="compte_id" value="<?php echo $compte->getId(); ?>">
                                <button type="submit" class="px-2 py-1 bg-green-500 text-white rounded text-xs hover:bg-green-600">
                                    Définir comme principal
                                </button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<div id="popup-compte-secondaire" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg shadow-lg p-8 w-full max-w-md">
        <h2 class="text-xl font-bold mb-6 text-maxitsa-orange">Ajouter un compte secondaire</h2>
        <!-- Affichage global des erreurs -->
        <?php if (!empty($errors)): ?>
            <div class="mb-4 text-red-600">
                <?php foreach ($errors as $fieldErrors): ?>
                    <?php foreach ((array)$fieldErrors as $err): ?>
                        <div><?php echo htmlspecialchars($err); ?></div>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <form method="post" action="/ajouterCompteSecondaire">
            <div class="mb-4">
                <label class="block text-gray-700 mb-2" for="numerotel">Numéro de téléphone</label>
                <input type="text" name="numerotel" id="numerotel" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-maxitsa-orange">
                <?php if (!empty($errors['numerotel'])): ?>
                    <div class="text-red-600 text-sm mt-1">
                        <?php foreach ((array)$errors['numerotel'] as $err): ?>
                            <div><?php echo htmlspecialchars($err); ?></div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 mb-2" for="solde">Solde initial (optionnel)</label>
                <input type="number" name="solde" id="solde" min="0" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-maxitsa-orange">
                <?php if (!empty($errors['solde'])): ?>
                    <div class="text-red-600 text-sm mt-1">
                        <?php foreach ((array)$errors['solde'] as $err): ?>
                            <div><?php echo htmlspecialchars($err); ?></div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="flex justify-end space-x-2">
                <button type="button" id="close-popup" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Annuler</button>
                <button type="submit" class="px-4 py-2 bg-maxitsa-orange text-white rounded hover:bg-orange-600">Ajouter</button>
            </div>
        </form>
    </div>
</div>

<script>
    // Ouvre le popup au clic sur le bouton "Créer nouveau compte"
    document.querySelector('button.bg-maxitsa-orange').addEventListener('click', function(e) {
        e.preventDefault();
        document.getElementById('popup-compte-secondaire').classList.remove('hidden');
    });
    // Ferme le popup au clic sur "Annuler"
    document.getElementById('close-popup').addEventListener('click', function() {
        document.getElementById('popup-compte-secondaire').classList.add('hidden');
    });
</script>

<?php if ($openPopup): ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('popup-compte-secondaire').classList.remove('hidden');
    });
</script>
<?php endif; ?>