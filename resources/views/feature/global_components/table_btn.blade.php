<div class="row">
    <?php if (!empty($action)): ?>
        <?php foreach ($action as $key => $value): ?>
            <div class="col mb-2">
                <?php if (isset($value['is_delete']) && $value['is_delete']): ?>
                    <form method="POST" action="{{$value['action']}}" enctype="multipart/form-data">
                        @csrf
                        @method('DELETE')
                        
                        <?php $textConfirmation = $value['textConfirmation']; ?>
                        <button type="submit" onclick="return confirm('{{ $textConfirmation }}')" class="{{$value['class']}}"><?php echo $value['title']; ?></button>
                    </form>
                <?php elseif (isset($value['is_update']) && $value['is_update']): ?>
                    <form method="POST" action="{{$value['action']}}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <?php $textConfirmation = $value['textConfirmation']; ?>
                        <button type="submit" onclick="return confirm('{{ $textConfirmation }}')" class="{{$value['class']}}"><?php echo $value['title']; ?></button>
                    </form>
                <?php else: ?>
                    <a href="{{$value['action']}}" class="{{$value['class']}}"><?php echo $value['title']; ?></a>
                <?php endif ?>
            </div>
        <?php endforeach ?>
    <?php endif ?>
</div>