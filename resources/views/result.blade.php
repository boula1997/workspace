<div class="row mt-5">
    @if ($action == 'create new module(or Open newly added module edit first methodology to avoid filling data)')
        <p class="text-white">code E:\xampp\htdocs\{{ isset($selectFlag)?$selectFlag:'' }}</p>
        <p class="text-white">cd /d E:\xampp\htdocs\{{ isset($selectFlag)?$selectFlag:'' }}</p>
        <div id="newModuleB">
            @foreach ($results as $result)
   
                 
                @if (explode('\\', pathsArr($result->path)[1])[count(explode('\\', pathsArr($result->path)[1])) - 1] !==
                        explode('\\', pathsArr($result->path)[0])[count(explode('\\', pathsArr($result->path)[0])) - 1] &&
                        explode('\\', pathsArr($result->path)[1])[abs(count(explode('\\', pathsArr($result->path)[1])) - 2)] !==
                            explode('\\', pathsArr($result->path)[0])[count(explode('\\', pathsArr($result->path)[0])) - 2]
                )
                    {{-- {{ dd(1) }} --}}

                    <p>ren
                        {{ 're' . trim(pathsArr($result->path)[0], '\\' . explode('\\', pathsArr($result->path)[0])[count(explode('\\', pathsArr($result->path)[0])) - 1]) }}

                        {{ explode('\\', pathsArr($result->path)[1])[abs(count(explode('\\', pathsArr($result->path)[1])) - 2)] }}
                    </p>



                    <p>ren
                        {{ str_replace($data['name'] . 's\\', $data['rname'] . 's\\', pathsArr($result->path)[0]) }}

                        {{ explode('\\', pathsArr($result->path)[1])[count(explode('\\', pathsArr($result->path)[1])) - 1] }}
                    </p>
                    <p>ren
                        {{ str_replace($data['name'] . '\\', $data['rname'] . '\\', pathsArr($result->path)[0]) }}

                        {{ explode('\\', pathsArr($result->path)[1])[count(explode('\\', pathsArr($result->path)[1])) - 1] }}
                    </p>
                @elseif (explode('\\', pathsArr($result->path)[1])[count(explode('\\', pathsArr($result->path)[1])) - 1] !==
                        explode('\\', pathsArr($result->path)[0])[count(explode('\\', pathsArr($result->path)[0])) - 1]
                )
                    {{-- {{ dd(2) }} --}}
                    <p>ren {{ pathsArr($result->path)[0] }}

                        {{ explode('\\', pathsArr($result->path)[1])[count(explode('\\', pathsArr($result->path)[1])) - 1] }}
                    </p>
                @else
                    {{-- {{ dd(3) }} --}}

                    <p>ren
                        @php
                            // Explode the path at the '*'
                            $pathParts = pathsArr($result->path);
                            $firstPart = $pathParts[0];
                            $secondPart = isset($pathParts[1]) ? $pathParts[1] : ''; // Ensure the second part exists

                            // Get the segments of the first part
                            $firstPartExploded = explode('\\', $firstPart);

                            // Remove the last segment (this will remove the last folder or file)
                            array_pop($firstPartExploded);

                            // Rebuild the first part without the last segment
                            $trimmedFirstPart = implode('\\', $firstPartExploded);

                            // Add 're' to the beginning of the rebuilt string
                            $resultString = $trimmedFirstPart;

                            // Ensure the second part has enough elements and get the desired part
                            $secondPartExploded = explode('\\', $secondPart);
                            $secondPartResult =
                                count($secondPartExploded) > 1
                                    ? $secondPartExploded[abs(count($secondPartExploded) - 2)]
                                    : '';
                        @endphp

                        {{ $resultString }}

                        {{ $secondPartResult }}
                    </p>
                @endif
            @endforeach
            @foreach ($results as $result)
                <p>git restore -- {{ pathsArr($result->path)[0] }}</p>
            @endforeach

            @if (isset($plural))
                @foreach ($results as $result)
                    <p>powershell -Command "(gc {{ pathsArr($result->path)[1] }}) -creplace
                        '{{ ucfirst($module) }}s',
                        '{{ ucfirst($plural) }}' | Out-File -encoding ASCII {{ pathsArr($result->path)[1] }}"
                    </p>
                @endforeach
                @foreach ($results as $result)
                    <p>powershell -Command "(gc {{ pathsArr($result->path)[1] }}) -creplace
                        '{{ $module }}s',
                        '{{ $plural }}' | Out-File -encoding ASCII {{ pathsArr($result->path)[1] }}"
                    </p>
                @endforeach
            @endif
            @foreach ($results as $result)
                <p>powershell -Command "(gc {{ pathsArr($result->path)[1] }}) -creplace '{{ ucfirst($module) }}s',
                    '{{ ucfirst($rmodule) }}s' | Out-File -encoding ASCII {{ pathsArr($result->path)[1] }}"
                </p>
            @endforeach
            @foreach ($results as $result)
                <p>powershell -Command "(gc {{ pathsArr($result->path)[1] }}) -creplace '{{ ucfirst($module) }}',
                    '{{ ucfirst($rmodule) }}' | Out-File -encoding ASCII {{ pathsArr($result->path)[1] }}"
                </p>
            @endforeach
            @foreach ($results as $result)
                <p>powershell -Command "(gc {{ pathsArr($result->path)[1] }}) -creplace '{{ $module }}',
                    '{{ $rmodule }}' | Out-File -encoding ASCII {{ pathsArr($result->path)[1] }}"
                </p>
            @endforeach
            @include('shared')

            <p>code E:\xampp\htdocs\{{ isset($selectFlag)?$selectFlag:'' }}</p>
            <p>cd /d E:\xampp\htdocs\{{ isset($selectFlag)?$selectFlag:'' }}</p>
            <p>code resources\lang\en\general.php</p>
            <p>code resources\lang\ar\general.php</p>
            <p>start https://chatgpt.com/</p>
            <p>php artisan translations:reset</p>
            <p>php artisan translations:import</p>
            <p>php artisan translations:find</p>
            <p>php artisan ser</p>
            <p>cls</p>
            <p>cls</p>
            <hr>
            @foreach ($results as $result)
                <p class="clickable-text" title="click to copy">code
                    {{ pathsArr($result->path)[1] }}
                </p>
            @endforeach
            <p class="clickable-text" title="click to copy" content="code app/helpers/helper.php">code
                app/helpers/helper.php</p>
            <p class="clickable-text" title="click to copy" content="code database/seeders/PermissionTableSeeder.php">
                code
                database/seeders/PermissionTableSeeder.php</p>
            <p class="clickable-text" title="click to copy" content="code resources/lang/ar/general.php">code
                resources/lang/ar/general.php</p>
            <p class="clickable-text" title="click to copy" content="code resources/lang/en/general.php">code
                resources/lang/en/general.php</p>
            <p class="clickable-text" title="click to copy" content="code resources/views/dashboard.blade.php">code
                resources/views/dashboard.blade.php</p>
            <p class="clickable-text" title="click to copy"
                content="code resources/views/admin/components/dashboard.blade.php">code
                resources/views/admin/components/dashboard.blade.php</p>
            <p class="clickable-text" title="click to copy"
                content="code resources/views/front/components/nav.blade.php">code
                resources/views/front/components/nav.blade.php</p>
            <p class="clickable-text" title="click to copy" content="code database\seeders\DatabaseSeeder.php">code
                database\seeders\DatabaseSeeder.php</p>
            <p class="clickable-text" title="click to copy" content="code routes/admin.php">code routes/admin.php</p>
            <p class="clickable-text" title="click to copy" content="code routes/api.php">code routes/api.php</p>
            <p class="clickable-text" title="click to copy" content="code routes/web.php">code routes/web.php</p>
            <p class="clickable-text" title="click to copy"
                content="code resources/views/admin/components/controls.blade.php">code
                resources/views/admin/components/controls.blade.php</p>
            <p class="clickable-text" title="click to copy" content="code src/App.jsx">code src/App.jsx</p>
            <p class="clickable-text" title="click to copy" content="code src/components/Menubar/index.jsx">code
                src/components/Menubar/index.jsx</p>
            <p class="clickable-text" title="click to copy" content="code src/pages/HomePage/index.jsx">code
                src/pages/HomePage/index.jsx</p>

            <p>code E:\xampp\htdocs\{{ isset($selectFlag)?$selectFlag:'' }}</p>
            <p>cd /d E:\xampp\htdocs\{{ isset($selectFlag)?$selectFlag:'' }}</p>
                        <p>code resources\lang\en\general.php</p>
                        <p>code resources\lang\ar\general.php</p>
            <p>start https://chatgpt.com/</p>
            <p>php artisan translations:reset</p>
            <p>php artisan translations:import</p>
            <p>php artisan translations:find</p>
            <p>php artisan ser</p>
            <p>cls</p>
            <p>cls</p>
            <h1>Additional Steps</h1>
            <p>Reblace all words of old module name with new module name using "Search only in Open Editors"
                option
                and "Aa" option also use extensions "ctrl + shift + h" and "ctrl + alt + eneter"</p>
            <p>replace small with small capital with capital plural with plural singular with singular</p>
            <p>After that using git start keeoping old module data and add new module data by coping the new git
                result and pate them away to return old result using -></p>
        </div>
        <hr class="text-white fw-bold">
        @foreach ($resultsauto as $scriptResult)
            {{-- <h4 class="text-warning">{{ $scriptResult['script_name'] }}</h4> --}}
            <div>
                @foreach ($scriptResult['results'] as $result)
                    {{ $result }}
                @endforeach
                <br>
                <br>
            </div>
        @endforeach
        <hr class="text-white fw-bold">
        <p>Translate the right side to arabic and french and english to put them in ar.php en.php fr.php</p>
        @foreach ($resultsTranslation as $result)
            @if (!str_contains($result->key, ' '))
                <p>"{{ $result->key }}" =>
                    "{{ str_replace('id', '', str_replace('_', ' ', Str::ucfirst($result->key))) }}", </p>
            @endif
        @endforeach
    @endif


    @if ($action == 'Reblace word in module')
        <p class="text-white">code E:\xampp\htdocs\{{ isset($selectFlag)?$selectFlag:'' }}</p>
        <p class="text-white">cd /d E:\xampp\htdocs\{{ isset($selectFlag)?$selectFlag:'' }}</p>
        <div id="newModuleB">
            @if (isset($plural))
                @foreach ($results as $result)
                    @if (!str_contains(str_replace('\\', '/', $result->path), 'http'))
                        <p>powershell -Command "(gc {{ str_replace('\\', '/', $result->path) }}) -creplace
                            '{{ ucfirst($word) }}s',
                            '{{ ucfirst($plural) }}' | Out-File -encoding ASCII {{ str_replace('\\', '/', $result->path) }}"
                        </p>
                    @endif
                @endforeach
                @foreach ($results as $result)
                    @if (!str_contains(str_replace('\\', '/', $result->path), 'http'))
                        <p>powershell -Command "(gc {{ str_replace('\\', '/', $result->path) }}) -creplace
                            '{{ $word }}s',
                            '{{ $plural }}' | Out-File -encoding ASCII {{ str_replace('\\', '/', $result->path) }}"
                        </p>
                    @endif
                @endforeach
            @endif

            @foreach ($results as $result)
                @if (!str_contains(str_replace('\\', '/', $result->path), 'http'))
                    <p>powershell -Command "(gc {{ str_replace('\\', '/', $result->path) }}) -creplace '{{ ucfirst($word) }}s',
                        '{{ ucfirst($replaceWord) }}s' | Out-File -encoding ASCII
                        {{ str_replace('\\', '/', $result->path) }}"
                    </p>
                @endif
            @endforeach
            @foreach ($results as $result)
                @if (!str_contains(str_replace('\\', '/', $result->path), 'http'))
                    <p>powershell -Command "(gc {{ str_replace('\\', '/', $result->path) }}) -creplace '{{ ucfirst($word) }}',
                        '{{ ucfirst($replaceWord) }}' | Out-File -encoding ASCII
                        {{ str_replace('\\', '/', $result->path) }}"
                    </p>
                @endif
            @endforeach
            @foreach ($results as $result)
                @if (!str_contains(str_replace('\\', '/', $result->path), 'http'))
                    <p>powershell -Command "(gc {{ str_replace('\\', '/', $result->path) }}) -creplace '{{ $word }}',
                        '{{ $replaceWord }}' | Out-File -encoding ASCII {{ str_replace('\\', '/', $result->path) }}"
                    </p>
                @endif
            @endforeach
            <p>code E:\xampp\htdocs\{{ isset($selectFlag)?$selectFlag:'' }}</p>
            <p>cd /d E:\xampp\htdocs\{{ isset($selectFlag)?$selectFlag:'' }}</p>
                        <p>code resources\lang\en\general.php</p>
                        <p>code resources\lang\ar\general.php</p>
            <p>start https://chatgpt.com/</p>
            <p>php artisan translations:reset</p>
            <p>php artisan translations:import</p>
            <p>php artisan translations:find</p>
            <p>php artisan ser</p>
            <p>cls</p>
            <p>cls</p>
        </div>
    @endif


    @if ($action == 'Rename module')
        <p class="text-white">code E:\xampp\htdocs\{{ isset($selectFlag)?$selectFlag:'' }}</p>
        <p class="text-white">cd /d E:\xampp\htdocs\{{ isset($selectFlag)?$selectFlag:'' }}</p>
        @foreach ($results as $result)
            @if (explode('\\', pathsArr($result->path)[1])[count(explode('\\', pathsArr($result->path)[1])) - 1] !==
                    explode('\\', pathsArr($result->path)[0])[count(explode('\\', pathsArr($result->path)[0])) - 1] &&
                    explode('\\', pathsArr($result->path)[1])[abs(count(explode('\\', pathsArr($result->path)[1])) - 2)] !==
                        explode('\\', pathsArr($result->path)[0])[count(explode('\\', pathsArr($result->path)[0])) - 2]
            )
                <p>ren
                    {{ 're' . trim(pathsArr($result->path)[0], '\\' . explode('\\', pathsArr($result->path)[0])[count(explode('\\', pathsArr($result->path)[0])) - 1]) }}

                    {{ explode('\\', pathsArr($result->path)[1])[abs(count(explode('\\', pathsArr($result->path)[1])) - 2)] }}
                </p>



                <p>ren
                    {{ str_replace($data['name'] . 's\\', $data['rname'] . 's\\', pathsArr($result->path)[0]) }}

                    {{ explode('\\', pathsArr($result->path)[1])[count(explode('\\', pathsArr($result->path)[1])) - 1] }}
                </p>
                <p>ren
                    {{ str_replace($data['name'] . '\\', $data['rname'] . '\\', pathsArr($result->path)[0]) }}

                    {{ explode('\\', pathsArr($result->path)[1])[count(explode('\\', pathsArr($result->path)[1])) - 1] }}
                </p>
            @elseif (explode('\\', pathsArr($result->path)[1])[count(explode('\\', pathsArr($result->path)[1])) - 1] !==
                    explode('\\', pathsArr($result->path)[0])[count(explode('\\', pathsArr($result->path)[0])) - 1]
            )
                <p>ren {{ pathsArr($result->path)[0] }}

                    {{ explode('\\', pathsArr($result->path)[1])[count(explode('\\', pathsArr($result->path)[1])) - 1] }}
                </p>
            @else
                <p>ren
                    {{ 're' . trim(pathsArr($result->path)[0], '\\' . explode('\\', pathsArr($result->path)[0])[count(explode('\\', pathsArr($result->path)[0])) - 1]) }}



                    {{ explode('\\', pathsArr($result->path)[1])[abs(count(explode('\\', pathsArr($result->path)[1])) - 2)] }}
                </p>
            @endif
        @endforeach

        @if (isset($plural))
            @foreach ($results as $result)
                <p>powershell -Command "(gc {{ pathsArr($result->path)[1] }}) -creplace
                    '{{ ucfirst($module) }}s',
                    '{{ ucfirst($plural) }}' | Out-File -encoding ASCII {{ pathsArr($result->path)[1] }}"
                </p>
            @endforeach
            @foreach ($results as $result)
                <p>powershell -Command "(gc {{ pathsArr($result->path)[1] }}) -creplace
                    '{{ $module }}s',
                    '{{ $plural }}' | Out-File -encoding ASCII {{ pathsArr($result->path)[1] }}"
                </p>
            @endforeach
        @endif
        @foreach ($results as $result)
            <p>powershell -Command "(gc {{ pathsArr($result->path)[1] }}) -creplace '{{ ucfirst($module) }}s',
                '{{ ucfirst($rmodule) }}s' | Out-File -encoding ASCII {{ pathsArr($result->path)[1] }}"
            </p>
        @endforeach
        @foreach ($results as $result)
            <p>powershell -Command "(gc {{ pathsArr($result->path)[1] }}) -creplace '{{ ucfirst($module) }}',
                '{{ ucfirst($rmodule) }}' | Out-File -encoding ASCII {{ pathsArr($result->path)[1] }}"
            </p>
        @endforeach
        @foreach ($results as $result)
            <p>powershell -Command "(gc {{ pathsArr($result->path)[1] }}) -creplace '{{ $module }}',
                '{{ $rmodule }}' | Out-File -encoding ASCII {{ pathsArr($result->path)[1] }}"
            </p>
        @endforeach
        @include('shared')
        <p>code E:\xampp\htdocs\{{ isset($selectFlag)?$selectFlag:'' }}</p>
        <p>cd /d E:\xampp\htdocs\{{ isset($selectFlag)?$selectFlag:'' }}</p>
                    <p>code resources\lang\en\general.php</p>
                        <p>code resources\lang\ar\general.php</p>
            <p>start https://chatgpt.com/</p>
            <p>php artisan translations:reset</p>
        <p>php artisan translations:import</p>
        <p>php artisan translations:find</p>
        <p>php artisan ser</p>
        <p>cls</p>
        <p>cls</p>
        <hr>
        <p class="clickable-text" title="click to copy" content="code app/helpers/helper.php">code
            app/helpers/helper.php</p>
        <p class="clickable-text" title="click to copy" content="code database/seeders/PermissionTableSeeder.php">code
            database/seeders/PermissionTableSeeder.php</p>
        <p class="clickable-text" title="click to copy" content="code resources/lang/ar/general.php">code
            resources/lang/ar/general.php</p>
        <p class="clickable-text" title="click to copy" content="code resources/lang/en/general.php">code
            resources/lang/en/general.php</p>
        <p class="clickable-text" title="click to copy" content="code resources/views/dashboard.blade.php">code
            resources/views/dashboard.blade.php</p>
        <p class="clickable-text" title="click to copy"
            content="code resources/views/admin/components/dashboard.blade.php">code
            resources/views/admin/components/dashboard.blade.php</p>
        <p class="clickable-text" title="click to copy" content="code resources/views/front/components/nav.blade.php">
            code resources/views/front/components/nav.blade.php</p>
        <p class="clickable-text" title="click to copy" content="code database\seeders\DatabaseSeeder.php">code
            database\seeders\DatabaseSeeder.php</p>
        <p class="clickable-text" title="click to copy" content="code routes/admin.php">code routes/admin.php</p>
        <p class="clickable-text" title="click to copy" content="code routes/api.php">code routes/api.php</p>
        <p class="clickable-text" title="click to copy" content="code routes/web.php">code routes/web.php</p>
        <p class="clickable-text" title="click to copy"
            content="code resources/views/admin/components/controls.blade.php">code
            resources/views/admin/components/controls.blade.php</p>
        <p class="clickable-text" title="click to copy" content="code src/App.jsx">code src/App.jsx</p>
        <p class="clickable-text" title="click to copy" content="code src/components/Menubar/index.jsx">code
            src/components/Menubar/index.jsx</p>
        <p class="clickable-text" title="click to copy" content="code src/pages/HomePage/index.jsx">code
            src/pages/HomePage/index.jsx</p>


        @foreach ($results as $result)
            <p class="clickable-text" title="click to copy"
                content="code
            {{ pathsArr($result->path)[1] }}">code
                {{ pathsArr($result->path)[1] }}
            </p>
        @endforeach
        <p>code E:\xampp\htdocs\{{ isset($selectFlag)?$selectFlag:'' }}</p>
        <p>cd /d E:\xampp\htdocs\{{ isset($selectFlag)?$selectFlag:'' }}</p>
                    <p>code resources\lang\en\general.php</p>
                        <p>code resources\lang\ar\general.php</p>
            <p>start https://chatgpt.com/</p>
            <p>php artisan translations:reset</p>
        <p>php artisan translations:import</p>
        <p>php artisan translations:find</p>
        <p>php artisan ser</p>
        <p>cls</p>
        <p>cls</p>


        <h1>Additional Steps</h1>
        <p>Reblace all words of old module name with new module name using "Search only in Open Editors" option
            and "Aa" option also use extensions "ctrl + shift + h" and "ctrl + alt + eneter"</p>
        <p>replace small with small capital with capital plural with plural singular with singular</p>
        <p>After that using git start keeoping old module data and add new module data by coping the new git
            result and pate them away to return old result using -></p>

            <hr class="text-white fw-bold">
            @foreach ($resultsauto as $scriptResult)
                {{-- <h4 class="text-warning">{{ $scriptResult['script_name'] }}</h4> --}}
                <div>
                    @foreach ($scriptResult['results'] as $result)
                        {{ $result }}
                    @endforeach
                    <br>
                    <br>
                </div>
            @endforeach
            <hr class="text-white fw-bold">
        <p>Translate the right side to arabic and french and english to put them in ar.php en.php fr.php</p>
            @foreach ($resultsTranslation as $result)
                @if (!str_contains($result->key, ' '))
                    <p>"{{ $result->key }}" =>
                        "{{ str_replace('id', '', str_replace('_', ' ', Str::ucfirst($result->key))) }}", </p>
                @endif
            @endforeach

    @endif
    @if ($action == 'Delete multible module')
        <p class="text-white">code E:\xampp\htdocs\{{ isset($selectFlag)?$selectFlag:'' }}</p>
        <p class="text-white">cd /d E:\xampp\htdocs\{{ isset($selectFlag)?$selectFlag:'' }}</p>
        @foreach ($results as $result)
            <p>del -f {{ str_replace('\\', '/', $result->path) }}</p>
        @endforeach
        <p>code E:\xampp\htdocs\{{ isset($selectFlag)?$selectFlag:'' }}</p>
        <p>cd /d E:\xampp\htdocs\{{ isset($selectFlag)?$selectFlag:'' }}</p>
                    <p>code resources\lang\en\general.php</p>
                        <p>code resources\lang\ar\general.php</p>
            <p>start https://chatgpt.com/</p>
            <p>php artisan translations:reset</p>
        <p>php artisan translations:import</p>
        <p>php artisan translations:find</p>
        <p>php artisan ser</p>
        <p>cls</p>
        <p>cls</p>
        <hr>
        <p class="clickable-text" title="click to copy" content="code app/helpers/helper.php">code
            app/helpers/helper.php</p>
        <p class="clickable-text" title="click to copy" content="code database/seeders/PermissionTableSeeder.php">
            code
            database/seeders/PermissionTableSeeder.php</p>
        <p class="clickable-text" title="click to copy" content="code resources/lang/ar/general.php">code
            resources/lang/ar/general.php</p>
        <p class="clickable-text" title="click to copy" content="code resources/lang/en/general.php">code
            resources/lang/en/general.php</p>
        <p class="clickable-text" title="click to copy" content="code resources/views/dashboard.blade.php">code
            resources/views/dashboard.blade.php</p>
        <p class="clickable-text" title="click to copy"
            content="code resources/views/admin/components/dashboard.blade.php">code
            resources/views/admin/components/dashboard.blade.php</p>
        <p class="clickable-text" title="click to copy"
            content="code resources/views/front/components/nav.blade.php">code
            resources/views/front/components/nav.blade.php</p>
        <p class="clickable-text" title="click to copy" content="code database/seeders/DatabaseSeeder.php">code
            database/seeders/DatabaseSeeder.php</p>
        <p class="clickable-text" title="click to copy" content="code routes/admin.php">code routes/admin.php</p>
        <p class="clickable-text" title="click to copy" content="code routes/api.php">code routes/api.php</p>
        <p class="clickable-text" title="click to copy" content="code routes/web.php">code routes/web.php</p>
        <p class="clickable-text" title="click to copy"
            content="code resources/views/admin/components/controls.blade.php">code
            resources/views/admin/components/controls.blade.php</p>
        <p class="clickable-text" title="click to copy" content="code src/App.jsx">code src/App.jsx</p>
        <p class="clickable-text" title="click to copy" content="code src/components/Menubar/index.jsx">code
            src/components/Menubar/index.jsx</p>
        <p>code E:\xampp\htdocs\{{ isset($selectFlag)?$selectFlag:'' }}</p>
        <p>cd /d E:\xampp\htdocs\{{ isset($selectFlag)?$selectFlag:'' }}</p>
                    <p>code resources\lang\en\general.php</p>
                        <p>code resources\lang\ar\general.php</p>
            <p>start https://chatgpt.com/</p>
            <p>php artisan translations:reset</p>
        <p>php artisan translations:import</p>
        <p>php artisan translations:find</p>
        <p>php artisan ser</p>
        <p>cls</p>
        <p>cls</p>


        <h1>Additional Steps</h1>
        <p>Search for module name using "Search only in Open Editors" option and use extensions "ctrl + shift +
            f"</p>
        <p>Delete all module content</p>
    @endif
    @if ($action == 'Open multible modules')
        <button class="btn btn-outline-success w-25 mx-3 my-2" id="openDashboard">Open Dashboard</button>
        <button class="btn btn-outline-success w-25 mx-3 my-2" id="openFront">Open Front</button>
        <button class="btn btn-outline-success w-25 mx-3 my-2" id="openAPI">Open API</button>
        <button class="btn btn-outline-success w-25 mx-3 my-2" id="showLinks">Show Links</button>
        <div id="links" class="d-none">
            @foreach ($array as $item)
                @if ($item != 'http:' && $item != 'https:')
                    @foreach ($results as $result)
                        @if (
                            (str_contains(str_replace('\\', '/', $result->path), 'http:') || str_contains(str_replace('\\', '/', $result->path), 'https:')) &&
                                str_contains(str_replace('\\', '/', $result->path), $item))
                            <p>start <span
                                    class="resultLink">{{ str_replace('5173\\1\\', '5173/', str_replace('\\', '/', $result->path)) }}</span>
                            </p>
                        @endif
                    @endforeach
                @endif
            @endforeach
            <hr>
        </div>
        {{-- <p class="text-warning">Note: this methodology depend on opening files that can lead to other files and these are the files that are not reachable from other files and can lead to other files</p> --}}
        <p class="text-white">code E:\xampp\htdocs\{{ isset($selectFlag)?$selectFlag:'' }}</p>
        <p class="text-white">cd /d E:\xampp\htdocs\{{ isset($selectFlag)?$selectFlag:'' }}</p>
        @foreach ($results as $result)
            @if (
                (!str_contains(str_replace('\\', '/', $result->path), 'http:') && !str_contains(str_replace('\\', '/', $result->path), 'https:')) ||
                    str_contains(str_replace('\\', '/', $result->path), '.js'))
                <p class="clickable-text" title="click to copy" content="code {{ str_replace('\\', '/', $result->path) }}">code
                    {{ str_replace('\\', '/', $result->path) }}</p>
            @endif
        @endforeach
        <p>code E:\xampp\htdocs\{{ isset($selectFlag)?$selectFlag:'' }}</p>
        <p>cd /d E:\xampp\htdocs\{{ isset($selectFlag)?$selectFlag:'' }}</p>
                    <p>code resources\lang\en\general.php</p>
                        <p>code resources\lang\ar\general.php</p>
            <p>start https://chatgpt.com/</p>
            <p>php artisan translations:reset</p>
        <p>php artisan translations:import</p>
        <p>php artisan translations:find</p>
        <p>php artisan ser</p>
        <p>cls</p>
        <p>cls</p>
        <hr>
        <p class="clickable-text" title="click to copy" content="code app/helpers/helper.php">code
            app/helpers/helper.php</p>
        <p class="clickable-text" title="click to copy" content="code database/seeders/PermissionTableSeeder.php">
            code database/seeders/PermissionTableSeeder.php</p>
        <p class="clickable-text" title="click to copy" content="code resources/lang/ar/general.php">code
            resources/lang/ar/general.php</p>
        <p class="clickable-text" title="click to copy" content="code resources/lang/en/general.php">code
            resources/lang/en/general.php</p>
        <p class="clickable-text" title="click to copy" content="code resources/views/dashboard.blade.php">code
            resources/views/dashboard.blade.php</p>
        <p class="clickable-text" title="click to copy"
            content="code resources/views/admin/components/dashboard.blade.php">code
            resources/views/admin/components/dashboard.blade.php</p>
        <p class="clickable-text" title="click to copy"
            content="code resources/views/front/components/nav.blade.php">code
            resources/views/front/components/nav.blade.php</p>
        <p class="clickable-text" title="click to copy" content="code database\seeders\DatabaseSeeder.php">code
            database\seeders\DatabaseSeeder.php</p>
        <p class="clickable-text" title="click to copy" content="code routes/admin.php">code routes/admin.php</p>
        <p class="clickable-text" title="click to copy" content="code routes/api.php">code routes/api.php</p>
        <p class="clickable-text" title="click to copy" content="code routes/web.php">code routes/web.php</p>
        <p class="clickable-text" title="click to copy"
            content="code resources/views/admin/components/controls.blade.php">code
            resources/views/admin/components/controls.blade.php</p>
        <p class="clickable-text" title="click to copy" content="code src/App.jsx">code src/App.jsx</p>
        <p class="clickable-text" title="click to copy" content="code src/components/Menubar/index.jsx">code
            src/components/Menubar/index.jsx</p>
        <p class="clickable-text" title="click to copy" content="code src/pages/HomePage/index.jsx">code
            src/pages/HomePage/index.jsx</p>
        <p>code E:\xampp\htdocs\{{ isset($selectFlag)?$selectFlag:'' }}</p>
        <p>cd /d E:\xampp\htdocs\{{ isset($selectFlag)?$selectFlag:'' }}</p>
                    <p>code resources\lang\en\general.php</p>
                        <p>code resources\lang\ar\general.php</p>
            <p>start https://chatgpt.com/</p>
            <p>php artisan translations:reset</p>
        <p>php artisan translations:import</p>
        <p>php artisan translations:find</p>
        <p>php artisan ser</p>
        <p>cls</p>
        <p>cls</p>

        <hr class="text-white fw-bold">
        @foreach ($resultsauto as $scriptResult)
            {{-- <h4 class="text-warning">{{ $scriptResult['script_name'] }}</h4> --}}
            <div>
                @foreach ($scriptResult['results'] as $result)
                    {{ $result }}
                @endforeach
                <br>
                <br>
            </div>
        @endforeach
        <hr class="text-white fw-bold">
        <p>Translate the right side to arabic and french and english to put them in ar.php en.php fr.php</p>
        @foreach ($resultsTranslation as $result)
            @if (!str_contains($result->key, ' '))
                <p>"{{ $result->key }}" =>
                    "{{ str_replace('id', '', str_replace('_', ' ', Str::ucfirst($result->key))) }}", </p>
            @endif
        @endforeach
    @endif

    @if ($action == 'copy multible modules using repo')
        <p class="text-white">code E:\xampp\htdocs\{{ isset($selectFlag)?$selectFlag:'' }}</p>
        <p class="text-white">cd /d E:\xampp\htdocs\{{ isset($selectFlag)?$selectFlag:'' }}</p>
        <p>git remote set-url origin {{ $repo }}</p>
        @foreach ($results as $result)
            <p>git checkout origin/main -- {{ str_replace('\\', '/', $result->path) }}</p>
        @endforeach
        <p>git remote set-url origin {{ $prepo }}</p>
        <p>code E:\xampp\htdocs\{{ isset($selectFlag)?$selectFlag:'' }}</p>
        <p>cd /d E:\xampp\htdocs\{{ isset($selectFlag)?$selectFlag:'' }}</p>
                    <p>code resources\lang\en\general.php</p>
                        <p>code resources\lang\ar\general.php</p>
            <p>start https://chatgpt.com/</p>
            <p>php artisan translations:reset</p>
        <p>php artisan translations:import</p>
        <p>php artisan translations:find</p>
        <p>php artisan ser</p>
        <p>cls</p>
        <p>cls</p>
        <hr>
        <p class="clickable-text" title="click to copy" content="code app/helpers/helper.php">code
            app/helpers/helper.php</p>
        <p class="clickable-text" title="click to copy" content="code database/seeders/PermissionTableSeeder.php">
            code database/seeders/PermissionTableSeeder.php</p>
        <p class="clickable-text" title="click to copy" content="code resources/lang/ar/general.php">code
            resources/lang/ar/general.php</p>
        <p class="clickable-text" title="click to copy" content="code resources/lang/en/general.php">code
            resources/lang/en/general.php</p>
        <p class="clickable-text" title="click to copy" content="code resources/views/dashboard.blade.php">code
            resources/views/dashboard.blade.php</p>
        <p class="clickable-text" title="click to copy"
            content="code resources/views/admin/components/dashboard.blade.php">code
            resources/views/admin/components/dashboard.blade.php</p>
        <p class="clickable-text" title="click to copy"
            content="code resources/views/front/components/nav.blade.php">code
            resources/views/front/components/nav.blade.php</p>
        <p class="clickable-text" title="click to copy" content="code database\seeders\DatabaseSeeder.php">code
            database\seeders\DatabaseSeeder.php</p>
        <p class="clickable-text" title="click to copy" content="code database\seeders\DatabaseSeeder.php">code
            database\seeders\DatabaseSeeder.php</p>
        <p class="clickable-text" title="click to copy" content="code routes/admin.php">code routes/admin.php</p>
        <p class="clickable-text" title="click to copy" content="code routes/api.php">code routes/api.php</p>
        <p class="clickable-text" title="click to copy" content="code routes/web.php">code routes/web.php</p>
        <p class="clickable-text" title="click to copy"
            content="code resources/views/admin/components/controls.blade.php">code
            resources/views/admin/components/controls.blade.php</p>
        <p class="clickable-text" title="click to copy" content="code src/App.jsx">code src/App.jsx</p>
        <p class="clickable-text" title="click to copy" content="code src/components/Menubar/index.jsx">code
            src/components/Menubar/index.jsx</p>
        <p class="clickable-text" title="click to copy" content="code src/pages/HomePage/index.jsx">code
            src/pages/HomePage/index.jsx</p>


        @foreach ($results as $result)
            <p class="clickable-text" title="click to copy" content="code
            {{ str_replace('\\', '/', $result->path) }}">code
                {{ str_replace('\\', '/', $result->path) }}
            </p>
        @endforeach
        <p>code E:\xampp\htdocs\{{ isset($selectFlag)?$selectFlag:'' }}</p>
        <p>cd /d E:\xampp\htdocs\{{ isset($selectFlag)?$selectFlag:'' }}</p>
                    <p>code resources\lang\en\general.php</p>
                        <p>code resources\lang\ar\general.php</p>
            <p>start https://chatgpt.com/</p>
            <p>php artisan translations:reset</p>
        <p>php artisan translations:import</p>
        <p>php artisan translations:find</p>
        <p>php artisan ser</p>
        <p>cls</p>
        <p>cls</p>

        <h1>Additional Steps</h1>
        <p>start adding module content to shared files which are permissions, seeder, dashboaed,
            routes,nav,lang,helper</p>
    @endif
    @if ($action == 'checkout multible module')
        <p class="text-white">code E:\xampp\htdocs\{{ isset($selectFlag)?$selectFlag:'' }}</p>
        <p class="text-white">cd /d E:\xampp\htdocs\{{ isset($selectFlag)?$selectFlag:'' }}</p>
        @foreach ($results as $result)
            <p>git checkout {{ $commit }} -- {{ str_replace('\\', '/', $result->path) }}</p>
        @endforeach
        <p>code E:\xampp\htdocs\{{ isset($selectFlag)?$selectFlag:'' }}</p>
        <p>cd /d E:\xampp\htdocs\{{ isset($selectFlag)?$selectFlag:'' }}</p>
                    <p>code resources\lang\en\general.php</p>
                        <p>code resources\lang\ar\general.php</p>
            <p>start https://chatgpt.com/</p>
            <p>php artisan translations:reset</p>
        <p>php artisan translations:import</p>
        <p>php artisan translations:find</p>
        <p>php artisan ser</p>
        <p>cls</p>
        <p>cls</p>
        <hr>
        <p class="clickable-text" title="click to copy" content="code app/helpers/helper.php">code
            app/helpers/helper.php</p>
        <p class="clickable-text" title="click to copy" content="code database/seeders/PermissionTableSeeder.php">
            code database/seeders/PermissionTableSeeder.php</p>
        <p class="clickable-text" title="click to copy" content="code resources/lang/ar/general.php">code
            resources/lang/ar/general.php</p>
        <p class="clickable-text" title="click to copy" content="code resources/lang/en/general.php">code
            resources/lang/en/general.php</p>
        <p class="clickable-text" title="click to copy" content="code resources/views/dashboard.blade.php">code
            resources/views/dashboard.blade.php</p>
        <p class="clickable-text" title="click to copy"
            content="code resources/views/admin/components/dashboard.blade.php">code
            resources/views/admin/components/dashboard.blade.php</p>
        <p class="clickable-text" title="click to copy"
            content="code resources/views/front/components/nav.blade.php">code
            resources/views/front/components/nav.blade.php</p>
        <p class="clickable-text" title="click to copy" content="code database\seeders\DatabaseSeeder.php">code
            database\seeders\DatabaseSeeder.php</p>
        <p class="clickable-text" title="click to copy" content="code database\seeders\DatabaseSeeder.php">code
            database\seeders\DatabaseSeeder.php</p>
        <p class="clickable-text" title="click to copy" content="code routes/admin.php">code routes/admin.php</p>
        <p class="clickable-text" title="click to copy" content="code routes/api.php">code routes/api.php</p>
        <p class="clickable-text" title="click to copy" content="code routes/web.php">code routes/web.php</p>
        <p class="clickable-text" title="click to copy"
            content="code resources/views/admin/components/controls.blade.php">code
            resources/views/admin/components/controls.blade.php</p>
        <p class="clickable-text" title="click to copy" content="code src/App.jsx">code src/App.jsx</p>
        <p class="clickable-text" title="click to copy" content="code src/components/Menubar/index.jsx">code
            src/components/Menubar/index.jsx</p>
        <p class="clickable-text" title="click to copy" content="code src/pages/HomePage/index.jsx">code
            src/pages/HomePage/index.jsx</p>

        @foreach ($results as $result)
            <p class="clickable-text" title="click to copy" content="code
            {{ str_replace('\\', '/', $result->path) }}">code
                {{ str_replace('\\', '/', $result->path) }}
            </p>
        @endforeach
        <p>code E:\xampp\htdocs\{{ isset($selectFlag)?$selectFlag:'' }}</p>
        <p>cd /d E:\xampp\htdocs\{{ isset($selectFlag)?$selectFlag:'' }}</p>
                    <p>code resources\lang\en\general.php</p>
                        <p>code resources\lang\ar\general.php</p>
            <p>start https://chatgpt.com/</p>
            <p>php artisan translations:reset</p>
        <p>php artisan translations:import</p>
        <p>php artisan translations:find</p>
        <p>php artisan ser</p>
        <p>cls</p>
        <p>cls</p>

    @endif


    @if ($action == 'Get files with size bigger than')
        @foreach ($results as $result)
            {{ dd(File::size('http://127.0.0.1:9000/assets/img/contact-bg-1.jpg')) }}
            @if (filesize(str_replace('\\', '/', $result->path)) > 1048576 * $size)
                <p class="clickable-text" title="click to copy" content="code {{ str_replace('\\', '/', $result->path) }}">code
                    {{ str_replace('\\', '/', $result->path) }}</p>
            @endif
        @endforeach
        <p>code E:\xampp\htdocs\{{ isset($selectFlag)?$selectFlag:'' }}</p>
        <p>cd /d E:\xampp\htdocs\{{ isset($selectFlag)?$selectFlag:'' }}</p>
                    <p>code resources\lang\en\general.php</p>
                        <p>code resources\lang\ar\general.php</p>
        <p>start https://chatgpt.com/</p>
        <p>php artisan translations:reset</p>
        <p>php artisan translations:import</p>
        <p>php artisan translations:find</p>
        <p>php artisan ser</p>
        <p>cls</p>
        <p>cls</p>

    @endif
    @if ($action == 'Show or Delete project images')
        <p>First You have to delete all files and then do the following</p>


        <div class="row">
            <div class="table-responsive d-flex justify-content-center">
                <table class="table table-dark table-striped">
                    <thead>
                        <tr>
                            <th scope="col">image 1</th>
                            <th scope="col">url 2</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($usedFiles as $result)
                            <tr class="">
                                <td><img src="{{ 'http://localhost/' . $dbname . '/public/' . $result->url }}"
                                        alt="" class="w-25"></td>
                                <td>{{ $result->url }}</td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>

        </div>


        @foreach ($usedFiles as $result)
            @if (str_contains($result->url, 'images'))
                <p>git restore -- public/{{ $result->url }}</p>
            @endif
        @endforeach
        <p>code E:\xampp\htdocs\{{ isset($selectFlag)?$selectFlag:'' }}</p>
        <p>cd /d E:\xampp\htdocs\{{ isset($selectFlag)?$selectFlag:'' }}</p>
                    <p>code resources\lang\en\general.php</p>
                        <p>code resources\lang\ar\general.php</p>
            <p>start https://chatgpt.com/</p>
            <p>php artisan translations:reset</p>
        <p>php artisan translations:import</p>
        <p>php artisan translations:find</p>
        <p>php artisan ser</p>
        <p>cls</p>
        <p>cls</p>

    @endif


    @if ($action == 'translate all attributes')
        <p class="text-white">code E:\xampp\htdocs\{{ isset($selectFlag)?$selectFlag:'' }}</p>
        <p class="text-white">cd /d E:\xampp\htdocs\{{ isset($selectFlag)?$selectFlag:'' }}</p>
        @foreach ($results as $result)
            <p>"{{ $result->COLUMN_NAME }}" => "{{ trim(Str::ucfirst($result->COLUMN_NAME), '_id') }}", </p>
        @endforeach
        @foreach ($results as $result)
            <p>"{{ $result->COLUMN_NAME }}" => "{{ trim(Str::ucfirst($result->COLUMN_NAME), '_id') }} in
                English", </p>
        @endforeach
        @foreach ($results as $result)
            <p>"{{ $result->COLUMN_NAME }}" => "{{ trim(Str::ucfirst($result->COLUMN_NAME), '_id') }} in
                Arabic", </p>
        @endforeach
    @endif
    @if ($action == 'translate untranslated words')
        <p>If you did not find a result use the following commands</p>
        <p>the package does not support @'lang So you have to</p>
        <p>use ctrl +shift +h with enabling regular ex pression option</p>
        <code>@langs*\('(.+?)'\)\s*</code>
        <code> {{ __('$1') }} this should be put into double curly brackts</code>
        <p><a href="https://github.com/barryvdh/laravel-translation-manager" target="__blank">Used Package</a>
        </p>
        <p class="text-white">code E:\xampp\htdocs\{{ isset($selectFlag)?$selectFlag:'' }}</p>
        <p class="text-white">cd /d E:\xampp\htdocs\{{ isset($selectFlag)?$selectFlag:'' }}</p>
        <p>code E:\xampp\htdocs\{{ isset($selectFlag)?$selectFlag:'' }}</p>
        <p>cd /d E:\xampp\htdocs\{{ isset($selectFlag)?$selectFlag:'' }}</p>
                    <p>code resources\lang\en\general.php</p>
                        <p>code resources\lang\ar\general.php</p>
            <p>start https://chatgpt.com/</p>
            <p>php artisan translations:reset</p>
        <p>php artisan translations:import</p>
        <p>php artisan translations:find</p>
        <p>php artisan ser</p>
        <p>cls</p>
        <p>cls</p>
        <hr class="text-white fw-bold">
        <p>Translate the right side to arabic and french and english to put them in ar.php en.php fr.php</p>
        @foreach ($results as $result)
            @if (!str_contains($result->key, ' '))
                <p>"{{ $result->key }}" =>
                    "{{ str_replace('id', '', str_replace('_', ' ', Str::ucfirst($result->key))) }}", </p>
            @endif
        @endforeach
    @endif

    @if ($action == 'Search all attributes at once')
        <textarea class="text-white " name="print" id="print" cols="30" rows="5"></textarea>
        <div id="printResult" class="text-white">

        </div>
        <div id="reultContent1" class="mt-5 mb-3">
            <p>exclude</p>
            public,vendor,storage,composer.lock,README.m,package-lock.json,app/Providers,config,tests
            <hr>
            <p>include</p>
            .php
            <hr>
            <div>
                {{ $string }}
            </div>
        </div>
        <hr>
        <div id="reultContent2">
            <div>
                {{ $string2 }}
            </div>
        </div>
    @endif

    @if ($action == 'Prebare multible modules to work on')
        <p class="text-white">code E:\xampp\htdocs\{{ isset($selectFlag)?$selectFlag:'' }}</p>
        <p class="text-white">cd /d E:\xampp\htdocs\{{ isset($selectFlag)?$selectFlag:'' }}</p>
        @foreach ($array as $item)
            @if ($item != 'http:' && $item != 'https:')
                @foreach ($results as $result)
                    @if (
                        (str_contains(str_replace('\\', '/', $result->path), 'http:') || str_contains(str_replace('\\', '/', $result->path), 'https:')) &&
                            str_contains(str_replace('\\', '/', $result->path), $item))
                        <p>start {{ str_replace('\\', '/', $result->path) }}</p>
                    @endif
                @endforeach
            @endif
        @endforeach
        <hr>

        @foreach ($results as $result)
            @if (!str_contains(str_replace('\\', '/', $result->path), 'http:') && !str_contains(str_replace('\\', '/', $result->path), 'https:'))
                <p class="clickable-text" title="click to copy" content="code {{ str_replace('\\', '/', $result->path) }}">code
                    {{ str_replace('\\', '/', $result->path) }}</p>
            @endif
        @endforeach
        <p>code E:\xampp\htdocs\{{ isset($selectFlag)?$selectFlag:'' }}</p>
        <p>cd /d E:\xampp\htdocs\{{ isset($selectFlag)?$selectFlag:'' }}</p>
                    <p>code resources\lang\en\general.php</p>
                        <p>code resources\lang\ar\general.php</p>
            <p>start https://chatgpt.com/</p>
            <p>php artisan translations:reset</p>
        <p>php artisan translations:import</p>
        <p>php artisan translations:find</p>
        <p>php artisan ser</p>
        <p>cls</p>
        <p>cls</p>
        <hr>
        <p class="clickable-text" title="click to copy" content="code app/helpers/helper.php">code
            app/helpers/helper.php</p>
        <p class="clickable-text" title="click to copy" content="code database/seeders/PermissionTableSeeder.php">
            code database/seeders/PermissionTableSeeder.php</p>
        <p class="clickable-text" title="click to copy" content="code resources/lang/ar/general.php">code
            resources/lang/ar/general.php</p>
        <p class="clickable-text" title="click to copy" content="code resources/lang/en/general.php">code
            resources/lang/en/general.php</p>
        <p class="clickable-text" title="click to copy" content="code resources/views/dashboard.blade.php">code
            resources/views/dashboard.blade.php</p>
        <p class="clickable-text" title="click to copy"
            content="code resources/views/admin/components/dashboard.blade.php">code
            resources/views/admin/components/dashboard.blade.php</p>
        <p class="clickable-text" title="click to copy"
            content="code resources/views/front/components/nav.blade.php">code
            resources/views/front/components/nav.blade.php</p>
        <p class="clickable-text" title="click to copy" content="code database\seeders\DatabaseSeeder.php">code
            database\seeders\DatabaseSeeder.php</p>
        <p class="clickable-text" title="click to copy" content="code routes/admin.php">code routes/admin.php</p>
        <p class="clickable-text" title="click to copy" content="code routes/api.php">code routes/api.php</p>
        <p class="clickable-text" title="click to copy" content="code routes/web.php">code routes/web.php</p>
        <p class="clickable-text" title="click to copy"
            content="code resources/views/admin/components/controls.blade.php">code
            resources/views/admin/components/controls.blade.php</p>
        <p class="clickable-text" title="click to copy" content="code src/App.jsx">code src/App.jsx</p>
        <p class="clickable-text" title="click to copy" content="code src/components/Menubar/index.jsx">code
            src/components/Menubar/index.jsx</p>
        <p class="clickable-text" title="click to copy" content="code src/pages/HomePage/index.jsx">code
            src/pages/HomePage/index.jsx</p>
        <p>code E:\xampp\htdocs\{{ isset($selectFlag)?$selectFlag:'' }}</p>
        <p>cd /d E:\xampp\htdocs\{{ isset($selectFlag)?$selectFlag:'' }}</p>
                    <p>code resources\lang\en\general.php</p>
                        <p>code resources\lang\ar\general.php</p>
            <p>start https://chatgpt.com/</p>
            <p>php artisan translations:reset</p>
        <p>php artisan translations:import</p>
        <p>php artisan translations:find</p>
        <p>php artisan ser</p>
        <p>cls</p>
        <p>cls</p>
        <div id="reultContent" class="mt-5">
            <h2>Attributes in general</h2>
            <div id="reultContent">
                {{ $string3 }}
            </div>
        </div>
        <div id="reultContent" class="mt-5">
            <h2>Attributes objects</h2>
            <div id="reultContent">
                {{ $string }}
            </div>
        </div>
        <div id="reultContent" class="mt-5">
            <h2>Attributes inputs</h2>
            <div id="reultContent">
                {{ $string2 }}
            </div>
        </div>

    @endif

    <div>
        @if ($action == 'search project modules')
            <p class="text-white">code E:\xampp\htdocs\{{ isset($selectFlag)?$selectFlag:'' }}</p>
            <p class="text-white">cd /d E:\xampp\htdocs\{{ isset($selectFlag)?$selectFlag:'' }}</p>
            @foreach ($modules as $module)
                @if (!str_contains($module->TABLE_NAME, 'translations'))
                    <h6>{{ $module->TABLE_NAME }}</h6>
                @endif
            @endforeach

            <h2>modules search</h2>
            <div id="reultContent">
                {{ $string3 }}
            </div>
        @endif
    </div>
    <div>
        @if ($action == 'Open Shared Module Files')
            <p class="text-white">code E:\xampp\htdocs\{{ isset($selectFlag)?$selectFlag:'' }}</p>
            <p class="text-white">cd /d E:\xampp\htdocs\{{ isset($selectFlag)?$selectFlag:'' }}</p>
            <p>code E:\xampp\htdocs\{{ isset($selectFlag)?$selectFlag:'' }}</p>
            <p>cd /d E:\xampp\htdocs\{{ isset($selectFlag)?$selectFlag:'' }}</p>
                        <p>code resources\lang\en\general.php</p>
                        <p>code resources\lang\ar\general.php</p>
            <p>start https://chatgpt.com/</p>
            <p>php artisan translations:reset</p>
            <p>php artisan translations:import</p>
            <p>php artisan translations:find</p>
            <p>php artisan ser</p>
            <p>cls</p>
            <p>cls</p>
            <hr>
            <p class="clickable-text" title="click to copy" content="code app/helpers/helper.php">code
                app/helpers/helper.php</p>
            <p class="clickable-text" title="click to copy"
                content="code database/seeders/PermissionTableSeeder.php">code
                database/seeders/PermissionTableSeeder.php</p>
            <p class="clickable-text" title="click to copy" content="code resources/lang/ar/general.php">code
                resources/lang/ar/general.php</p>
            <p class="clickable-text" title="click to copy" content="code resources/lang/en/general.php">code
                resources/lang/en/general.php</p>
            <p class="clickable-text" title="click to copy" content="code resources/views/dashboard.blade.php">code
                resources/views/dashboard.blade.php</p>
            <p class="clickable-text" title="click to copy"
                content="code resources/views/admin/components/dashboard.blade.php">code
                resources/views/admin/components/dashboard.blade.php</p>
            <p class="clickable-text" title="click to copy"
                content="code resources/views/front/components/nav.blade.php">code
                resources/views/front/components/nav.blade.php</p>
            <p class="clickable-text" title="click to copy" content="code database\seeders\DatabaseSeeder.php">code
                database\seeders\DatabaseSeeder.php</p>
            <p class="clickable-text" title="click to copy" content="code routes/admin.php">code routes/admin.php</p>
            <p class="clickable-text" title="click to copy" content="code routes/api.php">code routes/api.php</p>
            <p class="clickable-text" title="click to copy" content="code routes/web.php">code routes/web.php</p>
            <p class="clickable-text" title="click to copy"
                content="code resources/views/admin/components/controls.blade.php">code
                resources/views/admin/components/controls.blade.php</p>
            <p class="clickable-text" title="click to copy" content="code src/App.jsx">code src/App.jsx</p>
            <p class="clickable-text" title="click to copy" content="code src/components/Menubar/index.jsx">code
                src/components/Menubar/index.jsx</p>
            <p class="clickable-text" title="click to copy" content="code src/pages/HomePage/index.jsx">code
                src/pages/HomePage/index.jsx</p>
            <p>code E:\xampp\htdocs\{{ isset($selectFlag)?$selectFlag:'' }}</p>
            <p>cd /d E:\xampp\htdocs\{{ isset($selectFlag)?$selectFlag:'' }}</p>
                        <p>code resources\lang\en\general.php</p>
                        <p>code resources\lang\ar\general.php</p>
            <p>start https://chatgpt.com/</p>
            <p>php artisan translations:reset</p>
            <p>php artisan translations:import</p>
            <p>php artisan translations:find</p>
            <p>php artisan ser</p>
            <p>cls</p>
            <p>cls</p>

            <div id="reultContent" class="mt-5">
                <h2>modules search</h2>
                <div id="reultContent">
                    {{ $string3 }}
                </div>
            </div>
        @endif
    </div>
    <div class=" text-justify">
        @if ($action == 'desc database')
            <button class="btn btn-primary w-25 text-right fixed-top mt-5" id="resetDB"><span>Reset</span></button>

                <div class="d-flex">
                                <button id="runQueryBtn" class="btn btn-primary">Run Query in New Tab</button>
            
             <p class="mx-5">{{$dbname}}</p>
                </div>
            <div class="row mb-2 mt-5">
                <form method="post" class="d-flex" id="queryForm">
                    @csrf
                    <input class="form-control  mx-3 text-white  w-25" type="text" name="dbname" readonly
                        value="{{ old('dbname',$dbname) }}"  placeholder="Insert command to excute">
                    {{-- <input class="form-control  mx-3 text-white  w-50" type="text" name="queryCommand"
                        value="{{ old('queryCommand') }}" placeholder="Insert command to excute" id="queryCommand"> --}}
                     <textarea style="height: 50vh" class="form-control  mx-3 text-white  w-100" id="queryCommand" name="queryCommand" type="text" placeholder="Insert command to excute">{{ old('queryCommand') }}</textarea>
                    <button class="btn btn-secondary" type="submit">submit</button>
                </form>
                <div class="row px-4 mt-2">
                    <select calss="select" name="querySelect" id="querySelect">
                        <option value="search for query">Search for query</option>
                        @foreach ($queries as $query)
                           <option value="{{ $query->title }}">{{ $query->title }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="d-flex justify-content-between mt-5">
                @foreach (array_unique($letters) as $letter)
                    <div id="dbname" dbname="{{ $dbname }}">
                        <h4 class="letter" style="cursor:pointer;">{{ $letter }}</h4>
                        <div class="d-none">
                            @foreach ($tables as $table)
                                <div>
                                    @if ($table->TABLE_NAME[$startingOrderLetter] == $letter)
                                        <!-- Table Name -->
                                        <span id="table" style="cursor: pointer;" 
                                              content="{{$table->TABLE_NAME}}" 
                                              table="{{ $table->TABLE_NAME }}" 
                                              class="toggleRelation fw-bold clickable-text-db" 
                                              title="{{ str_replace('_id', '', $array2[$loop->index]) }}">
                                            {{ $table->TABLE_NAME }} 
                                            <span id="{{ $table->TABLE_NAME }}">({{$counts[$loop->index]}})</span>
                                        </span>
            
                                        <!-- Column Names under Table -->
                                        <span class="d-none text-warning {{ $array2[$loop->index] == '' || str_contains($table->TABLE_NAME, 'translation') ? 'd-none' : '' }} {{ str_contains($table->TABLE_NAME, 'translation') ? 'd-none' : '' }}">
                                            <br>
                                            <div class="d-none">{{ $i = $loop->index }}</div>
                                            @foreach (explode(' ', $array[$i]) as $item)
                                            <span  
                                            class="clickable-text-db" 
                                            style="cursor: pointer;" 
                                            content="{{ $item }}">
                                            {{ $item }}
                                        </span> 
                                        <span class="text-info">{{ explode(' ', $dataTypes[$i])[$loop->index] }}</span>
                                                </br> <!-- Line break after each column -->
                                            @endforeach
                                        </span>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
            

            <div id="jsonResult" class="row text-white mt-2">

            </div>

            <button class="btn btn-warning" id="selectsButton">Show Selects and other k</button>

            <button class="btn btn-warning" id="updatedatButton">Add updated_at to tables</button>

            <div id="updatedatQueries">
            @foreach ($tables as $table)
            <p>ALTER TABLE {{$table->TABLE_NAME}} ADD COLUMN `updated_at` TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP;</p>
            @endforeach
            </div>

            <div id="selectTables">
                <input type="number" class="noHide" id="timeInput" value="5">
                <input type="text" class="noHide" placeholder="insert a coulmn to import and export" id="columnInput" value="">
                <h3 class="text-warining">Search Selects</h3>
                @foreach ($tables as $table)
                    <div>
                        <span style="cursor: pointer;">
                            SELECT CONCAT(
                            'SELECT * FROM {{$table->TABLE_NAME}} WHERE ',
                            GROUP_CONCAT(CONCAT('`', COLUMN_NAME, '` LIKE ''%5 Stars%''') SEPARATOR ' OR ')
                            )
                            FROM INFORMATION_SCHEMA.COLUMNS
                            WHERE TABLE_NAME = '{{$table->TABLE_NAME}}'
                            AND TABLE_SCHEMA = '{{$dbname}}';
                        </span>
                    </div>
                @endforeach
                <span>cls</span>
                <h3 class="text-warining">Interval Selects</h3>
                @foreach ($tables as $table)
                    <div>
                        <span style="cursor: pointer;" content="SELECT * FROM {{ $table->TABLE_NAME }} WHERE (created_at >= NOW() - INTERVAL 5 MINUTE) OR (updated_at >= NOW() - INTERVAL 5 MINUTE) \G;" 
                            table="{{ $table->TABLE_NAME }}"
                            class="toggleRelation clickable-text-db">
                            SELECT * FROM {{ $table->TABLE_NAME }} WHERE (created_at >= NOW() - INTERVAL 5 MINUTE) OR (updated_at >= NOW() - INTERVAL 5 MINUTE) \G;
                        </span>
                    </div>
                @endforeach
                <span>cls</span>
                <div>
                    <code>
                        SELECT 
                        c.TABLE_NAME, 
                        c.COLUMN_NAME, 
                        c.DATA_TYPE, 
                        c.IS_NULLABLE, 
                        c.COLUMN_DEFAULT
                    FROM 
                        INFORMATION_SCHEMA.COLUMNS c
                    LEFT JOIN 
                        INFORMATION_SCHEMA.KEY_COLUMN_USAGE k
                    ON 
                        c.TABLE_NAME = k.TABLE_NAME 
                        AND c.COLUMN_NAME = k.COLUMN_NAME 
                        AND c.TABLE_SCHEMA = k.TABLE_SCHEMA
                    WHERE 
                        c.TABLE_SCHEMA = '{{$dbname}}'
                        AND c.DATA_TYPE IN ('int', 'decimal', 'float', 'double', 'bigint', 'smallint', 'tinyint', 'mediumint')
                        AND k.COLUMN_NAME IS NULL 
                        AND c.IS_NULLABLE = 'YES' 
                        AND c.COLUMN_NAME NOT LIKE '%_id%' 
                        AND c.COLUMN_NAME != 'id';
                    </code>
                </div>
                <div>
                    <div>mysqldump -u {{$dbname}} -p  {{$dbname}} > {{$dbname}}_export.sql</div>      
                    <div>mysqldump -u {{$dbname}} -p --complete-insert {{$dbname}} > {{$dbname}}_export.sql</div>      
                    <div>mysqldump -u {{$dbname}} -p --no-create-info --complete-insert --ignore-table={{$dbname}}.permissions --ignore-table={{$dbname}}.migrations {{$dbname}} >{{$dbname}}_export.sql</div>
                    <div>mysqldump -u {{$dbname}} -p --no-data {{$dbname}}> {{$dbname}}_export.sql</div>
                    <hr class="text-white">
                    <div>mysql -u {{$dbname}} -p {{$dbname}} < {{$dbname}}_export.sql</div>
                    <hr class="text-white">
                    <div>mysqldump -u {{$dbname}} -p --no-create-info --complete-insert {{$dbname}} <span class="columnName">permissions</span> > <span class="columnName">permissions</span>_table_export.sql</div>
                    
                    <div>mysqldump -u {{$dbname}} -p --no-data {{$dbname}} <span class="columnName">permissions</span> > <span class="columnName">permissions</span>_table_export.sql</div>
                
                    <div>mysqldump -u {{$dbname}} -p --complete-insert {{$dbname}}  <span class="columnName">permissions</span> > <span class="columnName">permissions</span>_table_export.sql</div>
                    <hr class="text-white">
                    
                    <div>mysql -u {{$dbname}} -p {{$dbname}} <span class="columnName">permissions</span> < <span class="columnName">permissions</span>_table_export.sql</div>
                    <hr class="text-white">
                    @if (!App::environment('local'))
                    <div>{{$credential->db_password}}</div>
                    @endif
                    <hr class="text-white">

                    <code>
                        <p>SET FOREIGN_KEY_CHECKS = 0;</p>
                        <p>TRUNCATE TABLE permissions;</p>
                        <p>SET FOREIGN_KEY_CHECKS = 1;</p>
                    </code>
                </div>
            </div>  
@if (App::environment('local')) 
@push('js')               
<script>
   document.addEventListener('DOMContentLoaded', function () {
       document.getElementById('runQueryBtn').addEventListener('click', function () {
           const now = new Date();
           now.setDate(now.getDate() - 1);

           const year = now.getFullYear();
           const month = String(now.getMonth() + 1).padStart(2, '0');
           const day = String(now.getDate()).padStart(2, '0');
           const hours = String(now.getHours()).padStart(2, '0');
           const minutes = String(now.getMinutes()).padStart(2, '0');
           const seconds = String(now.getSeconds()).padStart(2, '0');

           const yesterdayDateTime = `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;

           localStorage.setItem('minutes', yesterdayDateTime);

           const baseURL = `{{ url('/run-query') }}`;
           const queryParams = `?dbname={{ $dbname }}&username=root&password=&interval=${encodeURIComponent(yesterdayDateTime)}`;
           const fullURL = baseURL + queryParams;

           // Open the URL in a new tab
           window.open(fullURL, '_blank');
       });
   });
</script>
@endpush
@else
@push('js')               
<script>
   document.addEventListener('DOMContentLoaded', function () {
       document.getElementById('runQueryBtn').addEventListener('click', function () {
           const now = new Date();
           now.setDate(now.getDate() - 1);

           const year = now.getFullYear();
           const month = String(now.getMonth() + 1).padStart(2, '0');
           const day = String(now.getDate()).padStart(2, '0');
           const hours = String(now.getHours()).padStart(2, '0');
           const minutes = String(now.getMinutes()).padStart(2, '0');
           const seconds = String(now.getSeconds()).padStart(2, '0');

           const yesterdayDateTime = `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;

           localStorage.setItem('minutes', yesterdayDateTime);

           const baseURL = `{{ url('/run-query') }}`;
           const queryParams = `?dbname={{ $credential->db_name }}&username={{ $credential->db_username }}&password={{ $credential->db_password }}&interval=${encodeURIComponent(yesterdayDateTime)}`;
           const fullURL = baseURL + queryParams;

           window.open(fullURL, '_blank');
       });
   });
</script>
@endpush
@endif

        @endif
    </div>

    <div>
        <style>
    mark.match-highlight {
        background: yellow;
        padding: 0 2px;
    }
    mark.active-match {
        background: orange !important;
    }
</style>

        @if ($action == 'get multible scripts' || $action == 'get multible modules')
            <button class="fixed-top mt-5 btn btn-primary w-50" id="showDeletes">Show Deletes</button>
            {{-- <div class="row fixed-top mt-5 my-5 d-flex justify-content-center">
                <!-- Replacement form -->
                <form id="replacementForm mb-5">
                    <input class="" name="search" type="text" id="searchTerm" placeholder="word1,word2,....">
                    <input class="" name="replaceTerm" type="text" id="replaceTerm" placeholder="word3,word4,....">
                    <button class="btn btn-outline-secondary" type="button" id="replaceButton">Replace</button>
                </form>
            </div> --}}

            <div class="d-flex justify-content-center align-items-center my-3 gap-2">
                <input type="text" id="searchInput" placeholder="Search..." class="form-control w-25 noHide">
                <button class="btn btn-secondary" id="prevMatch">Prev</button>
                <button class="btn btn-primary" id="nextMatch">Next</button>
            </div>

            @if ($searchRefrences)
                <div id="contentToReplace" class="mt-5">
                    @foreach ($results as $result)
                        <div class="d-none hilightResult" array="{{ json_encode($array) }}"></div>
                        <pre class="text-white  resultContent">
                            {{ htmlspecialchars($result->codeLinks) }}
                        </pre>
                        <form method="post" id="{{ $result->id }}"
                            class="{{ $action == 'get multible scripts' ? 'script' : 'module' }}">
                            @csrf
                            @method('delete')
                            <button type="button" class="btn btn-outline-danger d-inline m-1 w-100"
                                data-bs-toggle="modal" data-bs-target="#exampleModal{{ $result->id }}">
                                Delete
                            </button>

                            <div class="modal fade" id="exampleModal{{ $result->id }}" tabindex="-1"
                                aria-labelledby="exampleModalLabel{{ $result->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title " id="exampleModalLabel{{ $result->id }}">
                                                Delete Flag</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>
                                                Are you sure you want to delete this script?<br><br>
                                                <span class="text-secondary text-limit" style="--lines:3;">
                                                    {{ $result->codeLinks }}
                                                </span>
                                            </p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-danger"
                                                data-bs-dismiss="modal">Delete</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    @endforeach
                </div>
            @else
                <div id="contentToReplace" class="mt-5">
                    @foreach ($results as $result)
                        <div class="d-none hilightResult" array="{{ json_encode($array) }}"></div>
                        <pre class="text-white  resultContent">
                            {{ htmlspecialchars($result->script) }}
                        </pre>
                        <form method="post" id="{{ $result->id }}"
                            class="{{ $action == 'get multible scripts' ? 'script' : 'module' }}">
                            @csrf
                            @method('delete')
                            <button type="button" class="btn btn-outline-danger d-inline m-1 w-100"
                                data-bs-toggle="modal" data-bs-target="#exampleModal{{ $result->id }}">
                                Delete
                            </button>

                            <div class="modal fade" id="exampleModal{{ $result->id }}" tabindex="-1"
                                aria-labelledby="exampleModalLabel{{ $result->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title " id="exampleModalLabel{{ $result->id }}">
                                                Delete Flag</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>
                                                Are you sure you want to delete this script?<br><br>
                                                <span class="text-secondary text-limit" style="--lines:3;">
                                                    {{ $result->script }}
                                                </span>
                                            </p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-danger"
                                                data-bs-dismiss="modal">Delete</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    @endforeach
                </div>

            @endif
        @endif
    </div>
    <div>
        @if ($action == 'Servers Hostings and git default')
            @include('servers')
        @endif
    </div>

    <div>
        @if ($action == 'Image Workspace')
            @include('images')
        @endif
    </div>


    <div>
        @if ($action == 'flags manager')
            @include('flags')
        @endif
    </div>
    <div>
        @if ($action == 'Get Stats')
            @include('stats')
        @endif
    </div>
    <div>
        @if ($action == 'auto attributes (edit first methodology to avoid filling data)')
            @foreach ($results as $scriptResult)
                {{-- <h4 class="text-warning">{{ $scriptResult['script_name'] }}</h4> --}}
                <div>
                    @foreach ($scriptResult['results'] as $result)
                        {{ $result }}
                    @endforeach
                    <br>
                    <br>
                </div>
            @endforeach
        @endif
    </div>
    <div>
        @if ($action == 'React post')
            {{-- <h4 class="text-warning">{{ $scriptResult['script_name'] }}</h4> --}}
            <div>
                <pre>{{ $content }}</pre>
            </div>

            @foreach ($results as $scriptResult)
            {{-- <h4 class="text-warning">{{ $scriptResult['script_name'] }}</h4> --}}
            <div>
                @foreach ($scriptResult['results'] as $result)
                    {{ $result }}
                @endforeach
                <br>
                <br>
            </div>
        @endforeach
        @endif
    </div>
    <div>
        @if ($action == 'ReactNative post')
            {{-- <h4 class="text-warning">{{ $scriptResult['script_name'] }}</h4> --}}
            <div>
                <pre>{{ $content }}</pre>
            </div>

            @foreach ($results as $scriptResult)
            {{-- <h4 class="text-warning">{{ $scriptResult['script_name'] }}</h4> --}}
            <div>
                @foreach ($scriptResult['results'] as $result)
                    {{ $result }}
                @endforeach
                <br>
                <br>
            </div>
        @endforeach
        @endif
    </div>
    <div>
        @if ($action == 'Ajax post')
            {{-- <h4 class="text-warning">{{ $scriptResult['script_name'] }}</h4> --}}
            <div>
                <pre>{{ $content }}</pre>
            </div>
        @endif
    </div>
    <div>
        @if ($action == 'Ajax get')
            {{-- <h4 class="text-warning">{{ $scriptResult['script_name'] }}</h4> --}}
            <div>
                <pre>{{ $content }}</pre>
            </div>
        @endif
    </div>
    <div>
        @if ($action == 'React get')
            {{-- <h4 class="text-warning">{{ $scriptResult['script_name'] }}</h4> --}}
            <div>
                <pre>{{ $content }}</pre>
            </div>
        @endif
    </div>
    <div>
        @if ($action == 'ReactNative get')
            {{-- <h4 class="text-warning">{{ $scriptResult['script_name'] }}</h4> --}}
            <div>
                <pre>{{ $content }}</pre>
            </div>
        @endif
    </div>
</div>
