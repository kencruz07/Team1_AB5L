<html>
	<head>
		<title><?=$title?></title>
	</head>

	<body>
		<h1><?=$header?></h1>

		<?php if($query->num_rows() > 0){ ?>
		<?php foreach($query->result() as $row): ?>
			<h3><?=$row->author?></h3>
			<p><?=$row->body?></p>
		<hr/>
		<?php endforeach; ?>
		<?php } ?>
		<?=anchor('blog','Back to Blog')?>

		<?=form_open('blog/comment_insert')?>
		<?=form_hidden('entry_id',$this->uri->segment(3))?>
		Comment
		<p><textarea name='body' rows='10'></textarea></p>
		Author
		<p><input type='text' name='author'/></p>
		<p><input type='submit' value='Submit Comment'/></p>
		
		<?=form_close()?>
	</body>
</html>