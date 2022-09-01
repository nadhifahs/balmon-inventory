<input form="form{{$ident}}" type="submit" value="Delete" class="mx-1 my-1 btn btn-sm btn-danger">
<form id="form{{$ident}}" action="{{$action}}" method="post">
@csrf
@method('delete')
</form>
