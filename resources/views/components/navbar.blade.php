 <!-- Navbar -->
 <nav class=" navbar navbar-expand navbar-dark navbar-light">
     <!-- Left navbar links -->
     <ul class="navbar-nav">
         <li class="nav-item d-none d-sm-inline-block">
             <a href="{{ route('staff.index') }}" class="nav-link">
                 <h5>
                     Js-adways
                 </h5>
             </a>
         </li>
     </ul>



     <ul class="navbar-nav ml-auto">

         <div class="d-flex align-self-center mx-2">
             <form action="{{ route('staff.index') }}" method="GET">

                 @if (isset($perPage))
                     <input type="hidden" name="perPage" value="{{ $perPage }}">
                 @endif

                 <input class="btn btn-light mx-2" type="text" name="name" placeholder="姓名"
                     value="{{ request('name') }}">
                 <input class="btn btn-light mx-2" type="text" name="phone" placeholder="電話"
                     value="{{ request('phone') }}">
                 <input class="btn btn-light mx-2" type="text" name="address" placeholder="地址"
                     value="{{ request('address') }}">
                 <input class="btn btn-light mx-2" type="text" name="message" placeholder="留言"
                     value="{{ request('message') }}">
                     
                 <button type="submit" class="btn btn-success mx-2">搜尋</button>
             </form>
         </div>

         <li class="nav-item">
             <a href="{{ route('staff.create') }}" class="nav-link">
                 <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                     class="bi bi-person-fill-add" viewBox="0 0 16 16">
                     <path
                         d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Zm.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 0 1-1 0v-1h-1a.5.5 0 0 1 0-1h1v-1a.5.5 0 0 1 1 0Zm-2-6a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                     <path
                         d="M2 13c0 1 1 1 1 1h5.256A4.493 4.493 0 0 1 8 12.5a4.49 4.49 0 0 1 1.544-3.393C9.077 9.038 8.564 9 8 9c-5 0-6 3-6 4Z" />
                 </svg></a>
         </li>
     </ul>
 </nav>
 <!-- /.navbar -->
