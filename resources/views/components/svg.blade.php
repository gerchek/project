{!! !empty($svgImage) && is_file($svgImage) ? file_get_contents(public_path($svgImage)) : '' !!}