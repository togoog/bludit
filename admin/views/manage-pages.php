<h2 class="title"><i class="fa fa-file-text-o"></i> <?php $Language->p('Manage pages') ?></h2>

<?php makeNavbar('manage'); ?>

<table class="table-bordered table-stripped">
	<thead>
		<tr>
			<th><?php $Language->p('Title') ?></th>
			<th><?php $Language->p('Parent') ?></th>
		</tr>
	</thead>
	<tbody>
	<?php

		foreach($pagesParents as $parentKey=>$pageList)
		{
			foreach($pageList as $Page)
			{
				if($parentKey!==NO_PARENT_CHAR) {
					$parentTitle = $pages[$Page->parentKey()]->title();
				}
				else {
					$parentTitle = '';
				}

				echo '<tr>';
				echo '<td>'.($Page->parentKey()?NO_PARENT_CHAR:'').'<a href="'.HTML_PATH_ADMIN_ROOT.'edit-page/'.$Page->key().'">'.($Page->published()?'':'['.$Language->g('Draft').'] ').($Page->title()?$Page->title():'['.$Language->g('Empty title').'] ').'</a></td>';
				echo '<td>'.$parentTitle.'</td>';
				echo '</tr>';
			}
		}

	?>
	</tbody>
</table>