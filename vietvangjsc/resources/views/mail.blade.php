<!DOCTYPE html>
<html lang="en-US">
  <head>
    <meta charset="utf-8">
  </head>
  <body>
    <h2>Thông tin liên hệ của khách hàng</h2>
    <div>
      Thông tin chi tiết
    </div>
    <hr/>
    <div>Họ và tên: {!! $fullname !!}</div>
    @if ($company!="")
        <div>Tên công ty: {!! $company !!} </div>
    @endif
    @if ($position!="")
        <div>Chức vụ: {!! $position !!} </div>
    @endif
        <div>Số điện thoại: {!! $tel !!}</div>
    @if ($email!="")
        <div>Email: {!! $email !!}</div>
    @endif
    @if (count($service) != 0)
        <div>Lĩnh vực:
            @foreach ($service as $key => $value) 
                {!! $value . ',  ' !!}
            @endforeach
        </div>
    @endif
    @if ($content!="")
        <div>Nội dung: {!! $content !!}</div>
    @endif
    <hr/>
  </body>
</html>
