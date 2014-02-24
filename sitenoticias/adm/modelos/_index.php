
<div class="mws-panel grid_8">
   <div class="mws-panel-header">
    <span class="mws-i-24 i-table-1">Noticias</span>
</div>
<div class="mws-panel-body">
    <div class="mws-panel-toolbar top clearfix">
        <ul>
            <li><a href="inserir.php" class="mws-ic-16 ic-accept">Inserir Noticias</a></li>
        </ul>
    </div>

			
			<table class="mws-datatable mws-table">
					<thead>
						<tr>
							<th>Titulo</th>                        
							<th colspan="2">Op&ccedil;&otilde;es</th>
						</tr>
					</thead>
					<tbody>
						
								<tr>
									<td><?=$titulo?></td>
									<td><a href="alterar.php?id=<?=$id;?>">Alterar</a></td>
									<td><a href="excluir.php?id=<?=$id;?>">Excluir</a></td>
								</tr>								
					
					</tbody>
				</table>			
		

</div>
</div>

