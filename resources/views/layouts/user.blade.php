<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/favicon.ico') }}" />
    <title>{{ config('BoolBnB', 'BoolBnB') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&family=Work+Sans:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
        integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!--TomTom-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/Searchbox.css') }}" />


    <!-- Scripts -->
    <script src="{{ asset('assets/js/Searchbox-web.js') }}"></script>
    <script src="{{ asset('assets/js/services-web.min.js') }}"></script>

    @vite(['resources/js/app.js'])
</head>

<body>
    <div id="app">


        @include('partials.header')

        <main id="site_main">
            <div class="container-fluid">
                <div class="row row-cols-2">
                    @include('partials.sidebar')



                    @yield('content')
                    <script type="text/javascript">
                        const searchBoxWrapper = document.querySelector('.searchBoxWrapper');
                        const options = {
                            searchOptions: {
                                key: "lU2LpBjuVan1SqiXXG1VU3k6mEyc2E0R",
                                language: "it-IT",
                                limit: 5,
                            },
                            autocompleteOptions: {
                                key: "lU2LpBjuVan1SqiXXG1VU3k6mEyc2E0R",
                                language: "it-IT",
                            },

                        }
                        const ttSearchBox = new tt.plugins.SearchBox(tt.services, options)
                        const searchBoxHTML = ttSearchBox.getSearchBoxHTML()
                        searchBoxWrapper.append(searchBoxHTML)
                        const searchBoxInput = document.querySelector('.tt-search-box-input');
                        const resultsContainer = document.querySelector('.tt-search-box-result-list-container')
                        searchBoxInput.name = 'address';
                        searchBoxInput.id = 'address'
                        searchBoxInput.setAttribute('value',
                            '{{ isset($apartment) ? old('address', $apartment->address) : old('address') }}')

                        searchBoxInput.addEventListener('input', function() {
                            if (this.value == '') {
                                resultsContainer.style.display = "none";
                            } else {
                                resultsContainer.style.display = "block";
                            }
                        })
                        searchBoxInput.addEventListener('blur', function() {
                            if (this.value == '') {
                                this.value = '{{ isset($apartment) ? old('address', $apartment->address) : old('address') }}';

                            }
                        })
                        searchBoxInput.addEventListener('focus', function() {
                            if (this.value == '') {
                                this.value = '{{ isset($apartment) ? old('address', $apartment->address) : old('address') }}'

                            }
                        })
                    </script>
                </div>
            </div>
        </main>

</body>

</html>
