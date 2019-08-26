# bit-laravel-gradebook
Laravel CRUD with authentication

laravel project

--- HELPERS ----



pager less -S 	// SQL rezultatai tvarkingoje leteleje
https://github.com/fzaninotto/Faker  // Faker
php artisan migrate:fresh --seed 	// visos lentos perkuriamos ir perseedinamos

-------------------------------------


--- DATABASE ----------

1. laravel new gradebook
1.a. composer update
2. Naudoti catalog useri, nes jis pritaikytas mysql 8 versijai arba
    CREATE USER 'newuser'@'localhost' IDENTIFIED WITH mysql_native_password BY 'password';
	priskirti jam naujai susikurta db
	apsirasyti viska .env faile
3. php artisan make:migration create_lectures_table
	php artisan make:migration create_students_table
	php artisan make:migration create_grades_table
4. Uzpildyti migraciju failus
	Migracijos (foreign key laukai turi buti unsigned ir nullable)
	timestamps
	indexes
	foreign key // daryti viska onDelete('restrict')
	database params
5. php artisan migrate

6. Jei reikia - specialus useris nustatomas ne factory, bet seed faile:
	factory('App\Product', 19)->create();
	factory('App\User', 3)->create();
    DB::table('users')
        ->updateOrInsert(
            [
                'email' => 'root',
            ],
            [
                'name' => 'Root Administrator',
                'email' => 'root',
                'password' => Hash::make('root'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);


--- MODEL formavimas -------
1. php artisan make:model Lecture  // ir kt.
2. uzpildyti visus modelius 	// pakeisti metodu pavadinimus ir turini
3. php artisan make:factory LectureFactory 		// pradeti nuo tu, kurie aprasomi kaip "one"
4. Uzpildyti visas factories iskaitant UserFactory 
5. Suvesti duomenis i database/seeds DatabaseSeeder.php
6. composer dump-autoload
7. php artisan db:seed

--- CONTROLLER formavimas ---------
1. php artisan make:controller GradeController;
2. susirasyti index metoda i kontroleri
3. susikurti visus reikalingus template pagal index kontroleri
4. persikopijuoti vius routus
5. Persikopijuoti visus templatus
6. Isirasyti paginator


--- PARTIALS ----
Persikopijuoti visus partials failus is resources/views/partials
Susitvarkyti navbara pagal save


--- VIEWS ----------
1. php artisan vendor:publish --tag=laravel-pagination	// Eksportuoti pagination i views direktorija
2. $grades-ar-kitas-kintamasis->links('vendor.pagination.default') 	// pakeisti pagination kintamojo varda
3. <link rel="stylesheet" href="{{ asset('css/app.css') }}"> 	// itraukti css i layout view
4. <script src="{{ asset('js/app.js') }}"></script>		// itraukti js i layout view
5. prideti table-striped table-responsive
6. <div class="pagination pagination-sm justify-content-center"> 	// centruoti pagination
7. Prideti container klase 
8. Prideti navbara (kopijuoti is gradebook projekto partials->navbar.blade)

--- EDIT -----
1. Susitvarkyti, kad butu tik tai ko reikia ir daryti POST i edit/save

--- EDIT SAVE ----
1. composer require mews/purifier	// parsisiusti purifieri
2. use Mews\Purifier\Facades\Purifier; 	// kontroleryje
3. Purifieris prideda <p>tagus - reikia numusti sita nesamone:
	php artisan vendor:publish --provider="Mews\Purifier\PurifierServiceProvider"
	config/purifier.php--> AutoFormat.AutoParagraph' => false,
	
--- DELETE ---------------
1. Kopijuoti is projekto grades kontrolerio ir index.blade koda ir turi veikti
2. Prideti koda, kuris tikrintu ar nebandoma trinti su kitomis lentelemis susijusiu duomenu:
    try{
    	$lecture->destroy($toBeDeleted);
	} catch (QueryException $e){
		return redirect()->back()->with('message', 'Cannot delete Lecture which has grades assigned to.');
	}
3. Prideti message koda templatuose, kurie bus rodomi esant sitai klaidai:
    @if(session()->has('message'))
        <div class="alert alert-danger">
            {{ session()->get('message') }}
        </div>
    @endif

--- ADD -----------
1. Susikurti metoda kontroleryje
2. Susikurti Route
3. Nusikopijuoti view
4. Pasidaryti blade pakeitimus

--- Kitos esybes ------
1. Copy-paste-edit


--- Login -------
1. Persikopijuoti visus login routus i web routeri
	Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
	Route::post('login', 'Auth\LoginController@login');
	Route::get('logout', 'Auth\LoginController@logout')->name('logout');
2. Pasikoreguoti LoginControler redirecTo url

2.a. Middleware/redirectIfAuthenticated reikia pakeisti redirest routa
3. jeigu auth/login.blade jau yra - sitame zingsnyje turetu jau veikti authentication forma /login puslapyje
4. reikia zinoti users lenteleje esanti email ir password, del pastovaus userio galima DatabaseSeeder faile naudoti auksciau aprasyta koda su default userio emailu ir passwordu
5. Dabar galima i partials/header.blade.php ikelti snipeta su logino kodu
<ul class="navbar-nav ml-auto">
    <li class="nav-item">
        {{ env('APP_TITLE') }}
    </li>
    @auth
        <li class="nav-item navbar-text text-white">
            {{ Auth::user()->name }},
            <a class="nav-item navbar-text nav-link" href="#" id="button-logout"
               onclick="event.preventDefault();
                   document.getElementById('form-logout').submit();">Logout</a>
            <form id="form-logout" method="POST" action="{{ route('logout') }}"
                  style="display: none;">@csrf
            </form>
            @else
                <a class="nav-item navbar-text nav-link" href="{{ route('login') }}">Login</a>
            @endauth
        </li>
</ul>
6. logout redirektui reikia prideti metoda i login controleri ($requestas turi buti symfony/httpfoundation....:
	    protected function loggedOut(Request $request) {
        return redirect(route('crud.grade.index'));
    }
6.a) logout galima daryti routa per GET vietoj POST ir tada nereiks jokiu slaptu formu 
7. Agaubti visu routus, kuriuos nori apsaugoti i funkcija:
	// CRUD Auth protected group
	Route::group(['middleware' => 'auth', 'prefix' => 'crud'], function () {
		// VISI ROUTAI
	});
	ARBA
	Prideti prie norimo paslepti routo:
		->middleware('auth');
8. paslepti norimus blade elementus po direktyvomis:
	@auth, @else, @endauth


--- REDAKTORIUS CKEditor ----------------------
0. https://artisansweb.net/install-use-ckeditor-laravel/
1. composer require unisharp/laravel-ckeditor
2. Next, open your config/app.php and place the below line to the providers array.
	Unisharp\Ckeditor\ServiceProvider::class,
3. php artisan vendor:publish --tag=ckeditor
4. Let’s say we have a textarea which should get replaced by CKEditor. To do so we are adding id ‘summary-ckeditor’ to the textarea.:
	<textarea class="form-control" id="summary-ckeditor" name="summary-ckeditor"></textarea>
5. Next, we need to include ckeditor.js file and write a JavaScript code which replaces textarea with CKEditor.
	<script src="{{ asset('vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
	<script>
		CKEDITOR.replace( 'summary-ckeditor' );
	</script>
	
	MUSU ATVEJU faile ck-editor.blade.php:
		<script src="{{ asset('vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
		<script>
			CKEDITOR.replace( 'ck-editor-field', {
			customConfig: '{{ asset('vendor/unisharp/laravel-ckeditor/config.js') }}',
			language: '{{ app()->getLocale() }}',
			htmlEncodeOutput: false,
			allowedContent: true,
			basicEntities: false,
			entities: true
			});
		</script>
6. Sutvarkyti templatus, kuriuose yra CKeditorius, kad rodytu formatuota teksta, tie laukai kurie rodo sita teksta, turi buti aprasomi ne su {{}}, bet {!! !!};
		


           
