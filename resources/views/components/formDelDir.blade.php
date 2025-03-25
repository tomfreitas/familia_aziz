<form action="{{$action}}" method="POST">
    @csrf
    <input type="hidden" name="_method" value="DELETE">
    <div>
            <td class="align-middle text-center"><i class="fa-solid fa-folder text-aviso"></i></td>
            <td class="align-middle"><a class="text-cinza text-decoration-none" href="{{ url('/file-manager/') }}@php echo '/'.$dir @endphp">{{ $dir }}</a></td>
            <td class="align-middle">Pasta</td>
            <td></td>
            <td class="text-center"><a href=""><i class="fa-solid fa-trash-can h5 my-0 mx-3 text-vermelho"></i></a></td>
    </div>
</form>
