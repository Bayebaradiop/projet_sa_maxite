

<div class="glass-effect rounded-3xl shadow-2xl p-8 w-full max-w-md hover-lift animate-fadeIn">
    <div class="text-center mb-8">
        <h1 class="text-4xl font-light text-gray-800 mb-2">Connexion</h1>
        <p class="text-gray-600 text-lg">Accédez à votre compte</p>
    </div>

    <?php if (isset($errors) && !empty($errors)): ?>
    <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-lg">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3">
                <ul class="list-disc pl-5 text-sm text-red-700">
                    <?php foreach ($errors as $field => $messages): ?>
                        <?php foreach ((array)$messages as $message): ?>
                            <li><?php echo htmlspecialchars($message); ?></li>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <form id="loginForm" class="space-y-6" action="/" method="post">
        <div>
            <label for="login" class="block text-gray-700 text-sm font-medium mb-2 uppercase tracking-wide">
                Identifiant
            </label>
            <input 
                type="text" 
                id="login" 
                name="login" 
                placeholder="Votre identifiant"
                value="<?php echo isset($login) ? htmlspecialchars($login) : ''; ?>"
                class="w-full px-4 py-3 bg-gray-50 border-2 <?php echo isset($errors['login']) ? 'border-red-500' : 'border-gray-200'; ?> rounded-xl focus:outline-none focus:border-indigo-500 focus:bg-white transition-all duration-300 text-gray-800 placeholder-gray-400"
                
            >
        </div>

        <div>
            <label for="password" class="block text-gray-700 text-sm font-medium mb-2 uppercase tracking-wide">
                Mot de passe
            </label>
            <input 
                type="password" 
                id="password" 
                name="password" 
                placeholder="••••••••"
                class="w-full px-4 py-3 bg-gray-50 border-2 <?php echo isset($errors['password']) ? 'border-red-500' : 'border-gray-200'; ?> rounded-xl focus:outline-none focus:border-indigo-500 focus:bg-white transition-all duration-300 text-gray-800 placeholder-gray-400"
            >
        </div>

        <button 
            type="submit" 
            class="w-full py-3 px-6 btn-gradient text-white font-semibold rounded-xl hover:shadow-lg transform hover:-translate-y-1 transition-all duration-300 uppercase tracking-widest"
        >
            Se connecter
        </button>
    </form>

    <div class="text-center mt-6">
        <a 
            href="#" 
            onclick="showForgotPassword()"
            class="text-indigo-600 hover:text-indigo-800 text-sm font-medium hover:underline transition-colors duration-300"
        >
            Mot de passe oublié ?
        </a>
    </div>

    <div class="flex items-center my-8">
        <div class="flex-1 border-t border-gray-300"></div>
        <span class="px-4 text-gray-500 text-sm">ou</span>
        <div class="flex-1 border-t border-gray-300"></div>
    </div>
    
    <div class="text-center mt-8 pt-6 border-t border-gray-200">
        <p class="text-gray-600">
            Pas encore de compte ? 
            <a href="/inscription" class="text-indigo-600 hover:text-indigo-800 font-medium hover:underline transition-colors duration-300">
                Créer un compte
            </a>
        </p>
    </div>
</div>


