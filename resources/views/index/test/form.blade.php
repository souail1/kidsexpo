<form action="test/post" method="POST">
    <input type="hidden" name="_token" value="{{csrf_token()}}">
    name
    <input type="text" name="name"><br/><br/>
    <input type="submit" value="post"/>
</form>