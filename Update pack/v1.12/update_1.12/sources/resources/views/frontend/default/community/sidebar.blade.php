 <div class="community-sidebar">
     <div class="widget">
         <div class="sidebar-cover"></div>
         <div class="profile-area">
             <img src="{{ get_image($auth->photo ?? '') }}">
             <h5>{{ $auth->name ?? 'User' }}</h5>
             <p>{{ $auth->role ?? 'Member' }}</p>
         </div>
         <ul class="community-menu">

             <li class="{{ request()->routeIs('posts') ? 'active' : '' }}">
                 <a href="{{ route('posts') }}">
                     <i class="fas fa-newspaper"></i>
                     {{ get_phrase('Posts') }}
                 </a>
             </li>
             <li class="{{ request()->routeIs('my.posts') ? 'active' : '' }}">
                 <a href="{{ route('my.posts') }}">
                     <i class="fas fa-file-alt"></i>
                     {{ get_phrase('My Posts') }}
                 </a>
             </li>

             <li class="{{ request()->routeIs('saved.posts') ? 'active' : '' }}">
                 <a href="{{ route('saved.posts') }}">
                     <i class="far fa-bookmark"></i>
                     {{ get_phrase('Saved Posts') }}
                 </a>
             </li>

             <li class="{{ request()->routeIs('privacy.policy') ? 'active' : '' }}">
                 <a href="{{ route('privacy.policy') }}">
                     <i class="fas fa-lock"></i>
                     {{ get_phrase('Privacy Policy') }}
                 </a>
             </li>
         </ul>
     </div>
 </div>
