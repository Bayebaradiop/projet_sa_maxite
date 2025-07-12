<div class="grid grid-cols-2 gap-6 bg-white rounded-lg shadow-lg p-8 w-full max-w-7xl h-auto">
  <div class="flex items-center justify-center h-[85vh]">
    <img src="fg.jpg" alt="Illustration" class="rounded-lg shadow-md h-full w-auto object-cover">
  </div>

  <div>
    <form method="post" enctype="multipart/form-data" action="/store">
      <div class="grid grid-cols-2 gap-6">
        <div class="mb-2">
          <label class="block text-gray-700 font-medium mb-2" for="nom">Nom *</label>
          <input type="text" id="nom" name="nom" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500 transition">
          <?php if (!empty($errors['nom'])): ?>
            <?php foreach ($errors['nom'] as $error): ?>
              <div class="text-red-600 text-sm"><?= htmlspecialchars($error) ?></div>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>

        <div class="mb-2">
          <label class="block text-gray-700 font-medium mb-2" for="prenom">Prénom *</label>
          <input type="text" id="prenom" name="prenom" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500 transition">
          <?php if (!empty($errors['prenom'])): ?>
            <?php foreach ($errors['prenom'] as $error): ?>
              <div class="text-red-600 text-sm"><?= htmlspecialchars($error) ?></div>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>

        <div class="mb-2">
          <label class="block text-gray-700 font-medium mb-2" for="login">Login *</label>
          <input type="text" id="login" name="login" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500 transition">
          <?php if (!empty($errors['login'])): ?>
            <?php foreach ($errors['login'] as $error): ?>
              <div class="text-red-600 text-sm"><?= htmlspecialchars($error) ?></div>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>

        <div class="mb-2">
          <label class="block text-gray-700 font-medium mb-2" for="password">Mot de passe *</label>
          <input type="password" id="password" name="password" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500 transition">
          <?php if (!empty($errors['password'])): ?>
            <?php foreach ($errors['password'] as $error): ?>
              <div class="text-red-600 text-sm"><?= htmlspecialchars($error) ?></div>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>

        <!-- Adresse -->
        <div class="mb-2">
          <label class="block text-gray-700 font-medium mb-2" for="adresse">Adresse *</label>
          <textarea id="adresse" name="adresse" rows="3" class="w-full border border-gray-300 rounded-lg px-2 focus:outline-none focus:ring-2 focus:ring-orange-500 transition"></textarea>
          <?php if (!empty($errors['adresse'])): ?>
            <?php foreach ($errors['adresse'] as $error): ?>
              <div class="text-red-600 text-sm"><?= htmlspecialchars($error) ?></div>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>

        <!-- Numéro de Carte d'identité -->
        <div class="mb-5">
          <label class="block text-gray-700 font-medium mb-2" for="numeroCarteidentite">Numéro de carte d'identité *</label>
          <input type="text" id="numeroCarteidentite" name="numeroCarteidentite" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500 transition">
          <?php if (!empty($errors['numeroCarteidentite'])): ?>
            <?php foreach ($errors['numeroCarteidentite'] as $error): ?>
              <div class="text-red-600 text-sm"><?= htmlspecialchars($error) ?></div>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>

        <!-- Photos Recto et Verso -->
        <div class="mb-5 col-span-2">
          <label class="block text-gray-700 font-medium mb-2">Photos Recto et Verso *</label>
          <input type="file" name="photorecto" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500 transition mb-8">
          <?php if (!empty($errors['photorecto'])): ?>
            <?php foreach ($errors['photorecto'] as $error): ?>
              <div class="text-red-600 text-sm"><?= htmlspecialchars($error) ?></div>
            <?php endforeach; ?>
          <?php endif; ?>
          <input type="file" name="photoverso" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500 transition">
          <?php if (!empty($errors['photoverso'])): ?>
            <?php foreach ($errors['photoverso'] as $error): ?>
              <div class="text-red-600 text-sm"><?= htmlspecialchars($error) ?></div>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>

        <div class="mb-2">
          <label class="block text-gray-700 font-medium mb-2" for="numerotel">Numéro de téléphone du compte *</label>
          <input type="tel" id="numerotel" name="numerotel" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500 transition">
          <?php if (!empty($errors['numerotel'])): ?>
            <?php foreach ($errors['numerotel'] as $error): ?>
              <div class="text-red-600 text-sm"><?= htmlspecialchars($error) ?></div>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>

        <input type="hidden" name="typecompte" value="Principal">

        <button
          type="submit"
          class="w-full bg-orange-500 text-white rounded-lg py-3 font-semibold hover:bg-orange-600 focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 transition">
          Inscription et Création de Compte
        </button>
      </div>
    </form>
  </div>
</div>