<div class="grid grid-cols-2 gap-6 bg-white rounded-lg shadow-lg p-8 w-full max-w-7xl h-auto">
  <div class="flex items-center justify-center h-[85vh]">
    <img src="fg.jpg" alt="Illustration" class="rounded-lg shadow-md h-full w-auto object-cover">
  </div>

  <div>
    <form method="post" enctype="multipart/form-data" action="/store">
      <!-- Numéro de Carte d'identité en haut -->
      <div class="mb-6 col-span-2">
        <label class="block text-gray-700 font-medium mb-2" for="numerocarteidentite">Numéro de carte d'identité *</label>
        <input type="text" id="numerocarteidentite" name="numerocarteidentite" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500 transition">
        <?php if (!empty($errors['numerocarteidentite'])): ?>
          <?php foreach ($errors['numerocarteidentite'] as $error): ?>
            <div class="text-red-600 text-sm"><?= htmlspecialchars($error) ?></div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>

      <div class="grid grid-cols-2 gap-6">
        
        <div class="mb-2">
          <label class="block text-gray-700 font-medium mb-2" for="nom">Nom *</label>
          <input type="text" id="nom" name="nom" readonly class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-gray-100 focus:outline-none">
          <?php if (!empty($errors['nom'])): ?>
            <?php foreach ($errors['nom'] as $error): ?>
              <div class="text-red-600 text-sm"><?= htmlspecialchars($error) ?></div>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>

        <div class="mb-2">
          <label class="block text-gray-700 font-medium mb-2" for="prenom">Prénom *</label>
          <input type="text" id="prenom" name="prenom" readonly class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-gray-100 focus:outline-none">
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



        <!-- Photos Recto et Verso -->
        <div class="mb-5 col-span-2" id="photo-section">
          <label class="block text-gray-700 font-medium mb-2">Photos Recto et Verso *</label>
          <div id="photos-preview" class="flex gap-4 mb-4" style="display:none;">
            <img id="photo-recto" src="" alt="Recto" class="h-32 rounded border border-gray-300">
            <img id="photo-verso" src="" alt="Verso" class="h-32 rounded border border-gray-300">
          </div>
          <input type="file" name="photorecto" id="input-recto" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500 transition mb-8">
          <?php if (!empty($errors['photorecto'])): ?>
            <?php foreach ($errors['photorecto'] as $error): ?>
              <div class="text-red-600 text-sm"><?= htmlspecialchars($error) ?></div>
            <?php endforeach; ?>
          <?php endif; ?>
          <input type="file" name="photoverso" id="input-verso" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500 transition">
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

<script>
const nciInput = document.getElementById('numerocarteidentite');
const nomInput = document.getElementById('nom');
const prenomInput = document.getElementById('prenom');
const photoRecto = document.getElementById('photo-recto');
const photoVerso = document.getElementById('photo-verso');
const photosPreview = document.getElementById('photos-preview');
const inputRecto = document.getElementById('input-recto');
const inputVerso = document.getElementById('input-verso');

// Ajoute un loader visuel à côté du champ NCI
let loader = document.createElement('span');
loader.textContent = 'Recherche...';
loader.style.display = 'none';
loader.style.marginLeft = '10px';
nciInput.parentNode.appendChild(loader);

nciInput.addEventListener('blur', async function() {
    const nci = this.value.trim();
    nomInput.value = '';
    prenomInput.value = '';
    photoRecto.src = '';
    photoVerso.src = '';
    photosPreview.style.display = 'none';
    inputRecto.style.display = '';
    inputVerso.style.display = '';
    if (nci.length === 13) {
        loader.style.display = 'inline';
        try {
            const response = await fetch(`https://appdaf-g15c.onrender.com/api/citoyen/${encodeURIComponent(nci)}`);
            const result = await response.json();
            if (result.statut === 'success' && result.data) {
                nomInput.value = result.data.nom;
                prenomInput.value = result.data.prenom;
                // Affiche les photos si elles existent
                if (result.data.url_carte_recto && result.data.url_carte_verso) {
                    photoRecto.src = result.data.url_carte_recto;
                    photoVerso.src = result.data.url_carte_verso;
                    photosPreview.style.display = 'flex';
                    inputRecto.style.display = 'none';
                    inputVerso.style.display = 'none';
                }
            }
        } catch (e) {
            nomInput.value = '';
            prenomInput.value = '';
            photoRecto.src = '';
            photoVerso.src = '';
            photosPreview.style.display = 'none';
            inputRecto.style.display = '';
            inputVerso.style.display = '';
        }
        loader.style.display = 'none';
    }
});
</script>