<!-- menu de la izquierda -->
<div id="menu" class="hidden-print hidden-xs sidebar-blue sidebar-brand-primary">
	<div id="sidebar-fusion-wrapper">
		<div id="brandWrapper" class="custom-logo">
			 <a href="{{ url('/') }}" class="display-block-inline pull-left">
			 	<img src="{{ asset('img/logo.png') }}" class="border-none" alt="GDI" style="width: 100px">
			 </a>
		</div>
		<ul class="menu list-unstyled" id="navigation_components">
			<li><a href="{{ url('polizas') }}" class="glyphicons notes_2"><i></i><span>PÓLIZAS</span></a></li>
			<li class="hasSubmenu">
				<a href="#submenuCaja" class="glyphicons usd" data-toggle="collapse"><i></i><span>CAJA</span></a>
				<ul id="submenuCaja" class="animated fadeIn collapse">
					<li class="text-small"><a href="{{ url('caja/cortes') }}" class="glyphicons chevron-right"><i></i><span>CORTE DE CAJA</span></a></li>
					<li class="text-small"><a href="{{ url('admin/servidores/alta') }}" class="glyphicons chevron-right"><i></i><span>EGRESOS</span></a></li>
				</ul>
			</li>
			<li class="hasSubmenu">
				<a href="#submenuReportes" class="glyphicons stats" data-toggle="collapse"><i></i><span>REPORTES</span></a>
				<ul id="submenuReportes" class="animated fadeIn collapse">
					<li class="text-small"><a href="{{ url('admin/servidores/alta') }}" class="glyphicons chevron-right"><i></i><span>COMISIONES</span></a></li>
				</ul>
			</li>
			<li class="hasSubmenu">
				<a href="#submenuAdmon" class="glyphicons cogwheels" data-toggle="collapse"><i></i><span>ADMINISTRACIÓN</span></a>
				<ul id="submenuAdmon" class="animated fadeIn collapse">
					<li class="text-small"><a href="{{ url('registrar') }}" class="glyphicons ban"><i></i><span>Agentes</span></a></li>
				</ul>
			</li>
		</ul>
	</div>
</div>
<!-- fin de menú -->