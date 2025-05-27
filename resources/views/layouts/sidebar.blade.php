

<!-- Sidebar -->
<div class="sidebar" id="sidebar">
				<div class="sidebar-inner slimscroll">
					<div id="sidebar-menu" class="sidebar-menu">
						<nav class="greedys sidebar-horizantal">
							<ul class="list-inline-item list-unstyled links">
								
							</ul>
							<!-- /Settings -->
						</nav>
						<ul class="sidebar-vertical ">
							<!-- Main -->

								<li>
									<a href="{{route('dashboard')}}"><i class="fe fe-grid"></i><span> Dashboard</span></a>									
								</li>
						
										
							@perm('authorization')
								<li class="menu-title"><span>Authorization</span></li>
								<li>
									<a href="{{route('permissions.index')}}"><i class="fe fe-lock"></i> <span> Permissions</span></a>
								</li>
								<li>
									<a href="{{route('roles.index')}}" class=""><i class="fe fe-shield"></i> <span> Roles</span></a>
								</li>
								<li>
									<a href="{{route('users.index')}}" class=""><i class="fe fe-user"></i> <span> Users</span></a>
								</li>
							@endperm

							<li class="menu-title"><span>Post</span></li>
							<li>
								<a href="{{route('permissions.index')}}"><i class="fe fe-lock"></i> <span> Post List</span></a>
							</li>
							<li>
								<a href="{{route('roles.index')}}" class=""><i class="fe fe-shield"></i> <span> Create Post</span></a>
							</li>
							
						</ul>
					</div>
				</div>
			</div>
			<!-- /Sidebar -->