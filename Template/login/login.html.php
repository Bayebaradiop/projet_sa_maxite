<!-- Formulaire de connexion Sonatel en Tailwind CSS -->
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-gray-900 via-gray-800 to-orange-400 p-4">
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-orange-sonatel to-orange-light rounded-full mb-4 animate-pulse shadow-lg">
                <!-- Logo SVG -->
                <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm3.5 6L12 10.5 8.5 8 12 5.5 15.5 8zM12 19c-3.31 0-6-2.69-6-6s2.69-6 6-6 6 2.69 6 6-2.69 6-6 6z" />
                </svg>
            </div>
            <h1 class="text-3xl font-light text-white mb-2">MAXITSA</h1>
            <p class="text-gray-300">Portail d'accès sécurisé</p>
        </div>

        <div class="bg-white bg-opacity-90 rounded-3xl shadow-2xl p-8 hover:-translate-y-1 transition-all duration-300">
            <div class="text-center mb-8">
                <h2 class="text-2xl font-semibold text-gray-800 mb-2">Connexion</h2>
                <p class="text-gray-600">Accédez à votre espace personnel</p>
            </div>

            <!-- Affichage des erreurs -->
            <?php if (isset($errors) && !empty($errors)): ?>
                <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-lg">
                    <ul class="list-disc pl-5 text-sm text-red-700">
                        <?php foreach ($errors as $field => $messages): ?>
                            <?php foreach ((array)$messages as $message): ?>
                                <li><?= htmlspecialchars($message) ?></li>
                            <?php endforeach; ?>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form id="loginForm" class="space-y-6" action="/" method="post">
                <div>
                    <label for="login" class="block text-gray-700 text-sm font-semibold mb-2 uppercase tracking-wide">
                        Identifiant
                    </label>
                    <input
                        type="text"
                        id="login"
                        name="login"
                        placeholder="Votre identifiant"
                        value="<?= isset($login) ? htmlspecialchars($login) : '' ?>"
                        class="w-full px-4 py-3 bg-gray-50 border-2 <?= isset($errors['login']) ? 'border-red-500' : 'border-gray-200' ?> rounded-xl focus:outline-none focus:border-orange-sonatel focus:bg-white transition-all duration-300 text-gray-800 placeholder-gray-400">
                </div>

                <div>
                    <label for="password" class="block text-gray-700 text-sm font-semibold mb-2 uppercase tracking-wide">
                        Mot de passe
                    </label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="••••••••"
                        class="w-full px-4 py-3 bg-gray-50 border-2 <?= isset($errors['password']) ? 'border-red-500' : 'border-gray-200' ?> rounded-xl focus:outline-none focus:border-orange-sonatel focus:bg-white transition-all duration-300 text-gray-800 placeholder-gray-400">
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input
                            id="remember"
                            name="remember"
                            type="checkbox"
                            class="h-4 w-4 text-orange-sonatel focus:ring-orange-sonatel border-gray-300 rounded">
                        <label for="remember" class="ml-2 block text-sm text-gray-700">
                            Se souvenir de moi
                        </label>
                    </div>
                    <a
                        href="#"
                        onclick="showForgotPassword()"
                        class="text-orange-sonatel hover:text-orange-dark text-sm font-medium hover:underline transition-colors duration-300">
                        Mot de passe oublié ?
                    </a>
                </div>

                <button
                    type="submit"
                    class="w-full py-3 px-6 btn-gradient text-white font-semibold rounded-xl hover:shadow-lg transform hover:-translate-y-1 transition-all duration-300 uppercase tracking-widest flex items-center justify-center space-x-2 group">
                    <span>Se connecter</span>
                    <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                    </svg>
                </button>
            </form>

            <div class="flex items-center my-8">
                <div class="flex-1 border-t border-gray-300"></div>
                <span class="px-4 text-gray-500 text-sm">ou</span>
                <div class="flex-1 border-t border-gray-300"></div>
            </div>

            <div class="text-center">
                <p class="text-gray-600">
                    Pas encore de compte ?
                    <a href="/inscription" class="text-orange-sonatel hover:text-orange-dark font-semibold hover:underline transition-colors duration-300">
                        Créer un compte
                    </a>
                </p>
            </div>
        </div>

        <div class="text-center mt-8 text-gray-400 text-sm">
            <p>&copy; 2025 Sonatel. Tous droits réservés.</p>
            <div class="mt-2 space-x-4">
                <a href="#" class="hover:text-orange-sonatel transition-colors">Conditions d'utilisation</a>
                <a href="#" class="hover:text-orange-sonatel transition-colors">Confidentialité</a>
                <a href="#" class="hover:text-orange-sonatel transition-colors">Support</a>
            </div>
        </div>
    </div>
</div>