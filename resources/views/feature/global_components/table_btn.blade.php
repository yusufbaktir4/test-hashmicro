<div class="flex justify-center">
    <?php if (!empty($action)): ?>
        <?php foreach ($action as $key => $value): ?>
            <div class="col mr-2">
                <?php if (isset($value['is_delete']) && $value['is_delete']): ?>
                    <form method="POST" action="{{$value['action']}}" enctype="multipart/form-data">
                        @csrf
                        @method('DELETE')
                        
                        <?php $textConfirmation = $value['textConfirmation']; ?>
                        <button type="submit" onclick="return confirm('{{ $textConfirmation }}')" class="inline-flex justify-center rounded-md py-2 px-3 text-sm font-semibold text-white shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 {{$value['class']}}"><?php echo $value['title']; ?></button>
                    </form>
                <?php elseif (isset($value['is_update']) && $value['is_update']): ?>
                    <form method="POST" action="{{$value['action']}}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <?php $textConfirmation = $value['textConfirmation']; ?>
                        <button type="submit" onclick="return confirm('{{ $textConfirmation }}')" class="inline-flex justify-center rounded-md py-2 px-3 text-sm font-semibold text-white shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 {{$value['class']}}"><?php echo $value['title']; ?></button>
                    </form>
                <?php else: ?>
                    <a href="{{$value['action']}}" class="inline-flex justify-center rounded-md py-2 px-3 text-sm font-semibold text-white shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 {{$value['class']}}"><?php echo $value['title']; ?></a>
                <?php endif ?>
            </div>
        <?php endforeach ?>
    <?php endif ?>
</div>