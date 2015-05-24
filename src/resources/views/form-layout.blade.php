<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Elegan Form Layout</title>
</head>
<body>

{{-- Copy this code to your custom layout --}}
{!! Form::model($resource, $formOptions) !!}
@include($formView)
{!! Form::close() !!}
{{-- End of code you can copy --}}

</body>
</html>
