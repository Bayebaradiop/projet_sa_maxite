<div class="grid grid-cols-2 gap-6 bg-white rounded-lg shadow-lg p-8 w-full max-w-7xl h-auto">
  <div class="flex items-center justify-center h-[85vh]">
    <img src="fg.jpg" alt="Illustration" class="rounded-lg shadow-md h-full w-auto object-cover">
  </div>

  <div>
    <form method="post" action="/store">
      <div class="grid grid-cols-2 gap-6">

        <!-- Numéro de Carte d'identité -->
        <div class="mb-5 col-span-2">
          <label class="block text-gray-700 font-medium mb-2" for="numerocarteidentite">Numéro de carte d'identité *</label>
          <input type="text" id="numerocarteidentite" name="numerocarteidentite" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500 transition">
          <?php foreach ((array)($errors['numerocarteidentite'] ?? []) as $error): ?>
            <div class="text-red-600 text-sm"><?= htmlspecialchars($error) ?></div>
          <?php endforeach; ?>
        </div>

        <!-- Login -->
        <div class="mb-2 col-span-2">
          <label class="block text-gray-700 font-medium mb-2" for="login">Login *</label>
          <input type="text" id="login" name="login" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500 transition">
          <?php foreach ((array)($errors['login'] ?? []) as $error): ?>
            <div class="text-red-600 text-sm"><?= htmlspecialchars($error) ?></div>
          <?php endforeach; ?>
        </div>

        <!-- Mot de passe -->
        <div class="mb-2 col-span-2">
          <label class="block text-gray-700 font-medium mb-2" for="password">Mot de passe *</label>
          <input type="password" id="password" name="password" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500 transition">
          <?php foreach ((array)($errors['password'] ?? []) as $error): ?>
            <div class="text-red-600 text-sm"><?= htmlspecialchars($error) ?></div>
          <?php endforeach; ?>
        </div>

        <!-- Adresse -->
        <div class="mb-2 col-span-2">
          <label class="block text-gray-700 font-medium mb-2" for="adresse">Adresse *</label>
          <textarea id="adresse" name="adresse" rows="3" class="w-full border border-gray-300 rounded-lg px-2 focus:outline-none focus:ring-2 focus:ring-orange-500 transition"></textarea>
          <?php foreach ((array)($errors['adresse'] ?? []) as $error): ?>
            <div class="text-red-600 text-sm"><?= htmlspecialchars($error) ?></div>
          <?php endforeach; ?>
        </div>

        <!-- Numéro de téléphone -->
        <div class="mb-2 col-span-2">
          <label class="block text-gray-700 font-medium mb-2" for="numerotel">Numéro de téléphone du compte *</label>
          <input type="tel" id="numerotel" name="numerotel" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500 transition">
          <?php foreach ((array)($errors['numerotel'] ?? []) as $error): ?>
            <div class="text-red-600 text-sm"><?= htmlspecialchars($error) ?></div>
          <?php endforeach; ?>
        </div>

        <input type="hidden" name="typecompte" value="Principal">

        <!-- Info AppDAF -->
        <div class="col-span-2 mb-4">
          <div class="text-blue-600 text-sm bg-blue-50 rounded p-2">
            Les informations personnelles et les photos de votre carte d'identité seront automatiquement récupérées via AppDAF.
          </div>
        </div>

        <div class="col-span-2">
          <button
            type="submit"
            class="w-full bg-orange-500 text-white rounded-lg py-3 font-semibold hover:bg-orange-600 focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 transition">
            Inscription et Création de Compte
          </button>
        </div>
      </div>
    </form>
  </div>
</div>