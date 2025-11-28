<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Karcher</title>
</head>
<body>

<h1>Каталог</h1>

<ul>
    @foreach($categories as $category)
        <li>
            {{ $category->translations->firstWhere('locale', 'ru')->name }}

            @if($category->children->count())
                <ul>
                    @foreach($category->children as $child)
                        <li>
                            {{ $child->translations->firstWhere('locale', 'ru')->name }}
                        </li>
                    @endforeach
                </ul>
            @endif

        </li>
    @endforeach
</ul>

</body>
</html>
<?php
