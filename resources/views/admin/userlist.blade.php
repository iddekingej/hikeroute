@extends("layouts.pagemenu")
@section("pagebody")
<div class="buttonBar"><a href='{{ route("admin.users.new") }}' class='buttonLink'><img src='/images/adduser.png'>Add new user</a></div>
<table class="table">
<tr><td colspan='3' class="table_title">User list</td></tr>
<tr>
	<td class="table_header">&nbsp;</td>
	<td class="table_header">Name</td>
	<td class="table_header">Email</td>
</tr>

@foreach($users as $user)
<tr>
	<td class="table_cell">
		@if(\Auth::user()->id != $user->id)
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