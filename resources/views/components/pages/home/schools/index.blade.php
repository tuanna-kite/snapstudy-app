<ul class="grid md:grid-cols-4 grid-cols-2 gap-4">
    @foreach ($listSchools as $school)
        <li>
            <x-pages.home.schools.card :school='$school' />
        </li>
    @endforeach
</ul>
