<div>
    @if($editMode)
    <div class="card">
        <div class="card-body row">       
            <div class="col-6">
                @if($cult_id==null)<h3>Nuovo lotto</h3>
                @else <h3>Modifica lotto</h3>
                @endif
                <form class="mt-4" action="">
                    <div class="form-group">
                        <label for="field_id"> Seleziona terreno</label>
                        <select name="field_id" wire:model="field_id" class="form-control">
                            <option value=''>Seleziona un terreno</option>
                            @foreach($fields as $field)
                                <option value={{ $field->id }}>{{ $field->name }}</option>
                            @endforeach
                        </select>
                        @error('plant_id') <span class="error text-danger">Devi selezionare un terreno</span> @enderror
                        @if(($this->points!=0)&&(count($this->points)>0)) <small id="emailHelp" class="form-text text-muted">Hai selezionato un lotto di {{ $superficie_tot }} mq @if($field_id != null) di {{ $field_sel->mq }} mq totali</small>@endif  @endif
                    </div>    
                    <div class="row">
                        <div class="form-group col-12 col-md-4">
                            <label for="name">Nome lotto</label>
                            <input type="text" wire:model="name" class="form-control">
                        </div>
                        <div class="form-group col-12 col-md-4">
                            <label for="width">Larghezza fila</label>
                            <input type="number" wire:model="width" class="form-control">
                        </div>
                        <div class="form-group col-12 col-md-4">
                            <label for="length">Lunghezza fila</label>
                            <input type="number" wire:model="length" class="form-control"> 
                        </div>
                        
                        @if(($points!=null))
                            @foreach ($points as $key => $item)
                                    <div class="row my-1">
                                        @foreach ($item as $key2 => $subitem)
                                            <div class="col">
                                                <input type="text" wire:model="points.{{ $key }}.{{$key2}}" class="form-control form-control-sm">
                                            </div>
                                        @endforeach
                                        <div class="col"> 
                                            <button type="button" name="remove" id="{{$key}}" wire:click="removePoint({{$key}})" class="btn btn-danger btn_remove  btn-sm"><i class="fas fa-trash "></i></button>
                                        </div>
                                    </div>
                            @endforeach
                        @endif
                    </div>
                    <button type="button" class="btn btn-primary mt-2 w-100" wire:click="saveCultivation"><i class="fas fa-save"></i> Salva</button>
                </form>
            
            </div>
            <div class="col-6">
                <button type="button" class="close pb-2" data-dismiss="modal" aria-label="Close" wire:click="toggleEdit">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div wire:init="initMapContent" class="map-container" wire:ignore>
                    <div id="map" class="mb-2"></div>
                </div> 
            </div>
        </div>
    </div>
    @else

   
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>Lotti</div>
                    <div class="d-flex align-items-center">
                        <label class="c-switch c-switch-pill c-switch-info">  
                            <input class="c-switch-input" type="checkbox" checked="" wire:model="mostraTutti"><span class="c-switch-slider"></span>
                        </label>
                    </div>
                    <div><button class="btn btn-primary" wire:click="toggleEdit"><i class="fas fa-plus"></i> Nuovo lotto</button></div>
                </div>
            </div>
            <div wire:init="initIndexMapContent" class="map-index-container">
                <div id="map-index" class="mb-2"></div>
            </div>   
            <div class="card-body"> 
               
                @if($fields!=null)
                    <div class="table-responsive">
                        <table class="table table-striped">
                            @foreach($fields as $lot)
                                <tr >
                                    <td>@if($lot->actual_cultivation() != null)<img class="img-fluid" style="height:50px;" src="{{ $lot->actual_cultivazion->plant->image }}">@else <img class="img-fluid" style="height:50px;" src="/img/img-placeholder.png">@endif</td>
                                    <td>{{ $lot->name }}</td>
                                  
                                    <td class="text-right">
                                        <button class="btn btn-dark" wire:click="setCultivation({{$lot->id}})">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-danger" wire:click="$emit('deleteTriggered',{{$lot->id}},'{{$lot->name}}')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                    {{ $fields->links() }}
                @endif  
            </div>
        </div>
    @endif
</div>
