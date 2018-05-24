	<div id="modal" class="modal">

		<div class="modal-content">
	<span class="close">&times;</span>
	<label>Nome da nova matéria</label><br>
		<input type='text' id='texto' name='novaMateria'>
	<input type='submit' id='submiter' name='submit' class='incluir' value='Adicionar Matéria'>
		</div>
	</div> 

	


	<script type="text/javascript">
			var modal = document.getElementById('modal');

			var btn = document.getElementById("abre");

			var span = document.getElementsByClassName("close")[0];

			var botao2 = document.getElementById("submiter");

			btn.onclick = function() 
			{
			    modal.style.display = "block";
			}

			span.onclick = function() 
			{
			    modal.style.display = "none";
			}

			window.onclick = function(event) 
			{
			    if (event.target == modal) 
			    {
			        modal.style.display = "none";
			    }
			}

			botao2.onclick = function()
			{
				modal.style.display = "none";
				<?php header("Location : auxPHP.php");?>
			}

	</script>