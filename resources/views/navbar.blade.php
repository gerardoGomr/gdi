<div class="navbar hidden-print box main navbar-primary" role="navigation" style="background: url('{{ url('img/fondo.png') }}') repeat-x">
	<div class="user-action user-action-btn-navbar pull-left border-right">
		<button class="btn btn-sm btn-navbar btn-primary btn-stroke" data-toggle="tooltip" data-original-title="Expander/contraer menú" data-placement="right"><i class="fa fa-bars fa-2x"></i></button>
	</div>

	<div class="col-md-6 visible-md visible-lg visible-xs padding-none">
		<div class="input-group innerL">
			<input id="txtBusqueda" name="txtBusqueda" type="text" class="form-control input-sm" placeholder="BÚSQUEDA RÁPIDA" autocomplete="off">
			<span class="input-group-btn">
				<button id="btnBuscar" name="btnBuscar" class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
			</span>
		</div>
	</div>

  	<div class="user-action pull-right menu-right-hidden-xs menu-left-hidden-xs border-left bg-inverse-faded">
		<div class="dropdown username hidden-xs pull-left">
			<a class="dropdown-toggle dropdown-hover" data-toggle="dropdown" href="#">
				<span class="media margin-none">
					<span class="media-body">
						<span class="strong text-6x"><i class="fa fa-user"></i> {{ request()->session()->get('usuario')->nombreCompleto() }}</span><span class="caret"></span><br>
						<span class="text-small">{{ request()->session()->get('usuario')->getOficina()->getNombre() }}</span>
					</span>
				</span>
			</a>
			<ul class="dropdown-menu pull-right">
				<li><a href="{{ url('perfil') }}"><i class="fa fa-gears"></i> MI CUENTA</a></li>
				<li><a href="{{ url('logout') }}"><i class="fa fa-sign-out"></i> CERRAR SESIÓN</a></li>
		    </ul>
		</div>

		<div class="dropdown dropdown-icons padding-none">
			<a class="btn btn-primary btn-circle dropdown-toggle dropdown-hover bg-white" data-toggle="dropdown"><i class="fa fa-info-circle"></i></a>
			<ul class="dropdown-menu">
				<li data-toggle="tooltip" data-title="Manual de usuario" data-placement="bottom" data-container="body" role="presentation">
					<a href=""><i class="fa fa-download"></i></a>
				</li>
			</ul>
		</div>
	</div>
	<div class="clearfix"></div>
</div>