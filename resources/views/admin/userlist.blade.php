@extends("layouts.pagemenu",["title"=>__("Users")])
@section("pagebody")
<table class="table">
<tr><td colspan='3' class="table_title">User list</td></tr>
<tr><td colspan='3' ><div class="buttonBar"><a href='{{ route("admin.users.new") }}' class='buttonLink'><img src='/images/adduser.png'>{{ __("Add new user") }}</a></div>
</td></tr>
<tr>
	<td class="table_header">&nbsp;</td>
	<td class="table_header">{{ __("Name") }}</td>
	<td class="table_header">{{ __("Email") }}</td>
</tr>

@foreach($users as $user)
<tr>
	<td class="table_cell">
		@if(\Auth::user()->id != $user->id && $user->canDelete())
		<a href='{{route("admin.users.delete",["id"=>$user->id])}}'><img src="/images/delete.png" /></a>
		@endif	
	</td>
	<td class="table_cell">
		<a href='{{route("admin.users.edit",["id"=>$user->id])}}'>{{ $user->name }}</a>
	</td>
	<td class="table_cell">
	{{ $user->email }}
	</td>
</tr>
@endforeach
</table>
@endsection