@include('pdfs.head', ['title' => 'liste des formations'])

<body bgcolor="#fff">
    <section style="margin:20px 40px;">

            <table width="100%" cellspacing="0" cellpadding="0">
              <tbody>
                <tr>
                  <td class="td-100 text-center bold" style="text-transform:uppercase;">
                      Liste des formations
                  </td>
                </tr>
              </tbody>
            </table>

      <table width="100%" cellspacing="0" cellpadding="0">
        <tbody>
          <tr>
            <td class="td-5">#</td>
            <td class="bold td-15">Titre</td>
            <td class="td-5">Catégorie</td>
            <td class="td-5">Nbre. Inscris</td>
          </tr>
        </tbody>
      </table>

          @foreach($formations as $formation)
            <table width="100%" cellspacing="0" cellpadding="0">
              <tbody>
                <tr data-href="{{ route('formation.edit', $formation->number) }}">
                    <td class="td-5">{{ $formation->number }}</td>
                    <td class="bold td-15">{{ $formation->title }}</td>
                    <td class="td-5">{{ $formation->category ? $formation->category->name : '---' }}</td>
                    <td class="td-5">{{ count($formation->etudiants) }}</td>
                </tr>
              </tbody>
            </table>
         @endforeach

    </section>

</body>
