@include('admin.includes.alerts')
<div class="row">
    <div class="col-lg-8 col-md-8 col-sm-6 col-xs-12">
        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-6 col-xs-12">
                <div class="form-group">
                    <label for="title">Nome Completo:</label>
                    <input type="text" name="name" class="form-control" placeholder="Nome Completo"
                        value="{{ $occurrence->name ?? old('name') }}">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-6 col-xs-12">
                <div class="form-group">
                    <label for="title">Titulo:</label>
                    <input type="text" name="title" class="form-control" placeholder="Titulo"
                        value="{{ $occurrence->title ?? old('title') }}">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-6 col-xs-12">
                <div class="form-group">
                    <label for="title">Endereço:</label>
                    <input type="text" name="address" class="form-control" placeholder="Endereço"
                        value="{{ $occurrence->address ?? old('address') }}">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-6 col-xs-12">
                <div class="form-group">
                    <label for="title">E-mail:</label>
                    <input type="email" name="email" class="form-control" placeholder="E-mail"
                        value="{{ $occurrence->email ?? old('email') }}">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="form-group">
                    <label for="latitude">Latitude:</label>
                    <input type="text" name="latitude" class="form-control" placeholder="Latitude"
                        value="{{ $occurrence->latitude ?? old('latitude') }}">
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="form-group">
                    <label for="longitude">Longitude:</label>
                    <input type="text" name="longitude" class="form-control" placeholder="Longitude"
                        value="{{ $occurrence->longitude ?? old('longitude') }}">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="form-group">
                    <label for="type_occurrences_id">Tipo Ocorrência:</label>
                    <input type="text" name="type_occurrences_id" class="form-control" placeholder="Tipo Ocorrência"
                        value="{{ $occurrence->type_occurrences_id ?? old('type_occurrences_id') }}">
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="form-group">
                    <label for="issuings_id">Orgão:</label>
                    <input type="text" name="issuings_id" class="form-control" placeholder="Orgão"
                        value="{{ $occurrence->issuings_id ?? old('issuings_id') }}">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                <label>Anexo:</label>
                <input type="file" name="anexo" class="form-control">
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-6 col-xs-12">
                <div class="form-group">
                    <label for="description">Descrição:</label>
                    <textarea cols="40" rows="5"
                        class="form-control">{{ $occurrence->description ?? old('description') }}</textarea>

                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
            <div class="form-group">
                <button type="submit" class="btn btn-block btn-success">Salvar</button>
            </div>
        </div>
    </div>

</div>
<!--row-->
