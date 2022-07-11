{{--if there is an x you can fill in both fields--}}
@extends('layouts.app')

@section('header')
    Create an Initial Check
@endsection

@section('content')
    <section class="content">
        <form method="POST" action="{{route('initial.store')}}">
            @csrf

            <section class="section">
                {{--Bovendek--}}
                <section class="section">
                    <section class="hero">
                        <div class="hero-body">
                            <h5 class="card bg-gradient-purple">Bovendek</h5>
                        </div>
                    </section>

                    <table class="table table-bordered table-hover table-secondary">
                        <tr>
                            <th></th>
                            <th>Condition</th>
                            <th>Aangepast naar</th>
                            <th>Ht/Kd: vocht %</th>
                        </tr>

                        <tr>
                            <td>Afmeting</td>



                            <td>
                                <div @error('afmetingTickB') is-danger @enderror" >
                                <label for="afmetingTickB" class="has-text-success has-text-weight-bold" style = "font-size: 35px;">&check;</label>
                                <input type="radio" style = "width:40px; height:40px" id="" name="afmetingTickB" value="1" @if(old('afmetingTickB') ==  '1') checked @endif>
                                <label for="afmetingTickB" class="has-text-danger has-text-weight-bold" style = "font-size: 35px;">	&cross;</label>
                                <input type="radio" style = "width:40px; height:40px" id="" name="afmetingTickB" value="0" @if(old('afmetingTickB') ==  '0') checked @endif>

                                </div>
                                @error('afmetingTickB')
                                <p class="help is-danger">{{ $message }}</p>
                                @enderror
                            </td>
                            <td>
                                <div class="control ">
                                    <input class="input form-control" value="{{old('afmetingAangB')}}" type="text" name="afmetingAangB" id=""  >
                                </div>
                            </td>
                            <td>
                                <div class="control ">
                                    <input class="input form-control" value="{{old('afmetingHtKdB')}}" type="text" name="afmetingHtKdB" id="" >
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>Aantal planken</td>
                            <td>
                                <div @error('aantalTick') is-danger @enderror" >
                                <label for="aantalTick" class="has-text-success has-text-weight-bold" style = "font-size: 35px;">&check;</label>
                                <input type="radio" style = "width:40px; height:40px" id="" name="aantalTick" value="1" @if(old('aantalTick') ==  '1') checked @endif>
                                <label for="aantalTick" class="has-text-danger has-text-weight-bold" style = "font-size: 35px;">&cross;</label>
                                <input type="radio" style = "width:40px; height:40px" id="" name="aantalTick" value="0" @if(old('aantalTick') ==  '0') checked @endif>

                                </div>
                                @error('aantalTick')
                                <p class="help is-danger">{{ $message }}</p>
                                @enderror
                            </td>

                            <td>
                                <div class="control ">
                                    <input class="input form-control" value="{{old('aantalAang')}}" type="text" name="aantalAang" id="" >
                                </div>
                            </td>

                            <td>
                                <div class="control ">
                                    <input class="input form-control" value="{{old('aantalHtKd')}}" type="text" name="aantalHtKd" id="">
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>Klampen</td>
                            <td>
                                <div @error('klampenTick') is-danger @enderror" >
                                <label for="klampenTick" class="has-text-success has-text-weight-bold" style = "font-size: 35px;">&check;</label>
                                <input type="radio" style = "width:40px; height:40px" id="" name="klampenTick" value="1" @if(old('klampenTick') ==  '1') checked @endif>
                                <label for="klampenTick" class="has-text-danger has-text-weight-bold" style = "font-size: 35px;">&cross;</label>
                                <input type="radio" style = "width:40px; height:40px" id="" name="klampenTick" value="0" @if(old('klampenTick') ==  '0') checked @endif>

                                </div>
                                @error('klampenTick')
                                <p class="help is-danger">{{ $message }}</p>
                                @enderror
                            </td>

                            <td>
                                <div class="control ">
                                    <input class="input form-control" value="{{old('klampenAang')}}" type="text" name="klampenAang" id=" ">
                                </div>
                            </td>

                            <td>
                                <div class="control ">
                                    <input class="input form-control" value="{{old('klampenHtKd')}}" type="text" name="klampenHtKd" id="">
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>Schimmel Ja/Nee</td>

                            <td>
                                <div @error('schimmelTick') is-danger @enderror" >
                                <label for="schimmelTick" class="has-text-success has-text-weight-bold" style = "font-size: 35px;">&check;</label>
                                <input type="radio" style = "width:40px; height:40px" id="" name="schimmelTick" value="1" @if(old('schimmelTick') ==  '1') checked @endif>
                                <label for="schimmelTick" class="has-text-danger has-text-weight-bold" style = "font-size: 35px;">&cross;</label>
                                <input type="radio" style = "width:40px; height:40px" id="" name="schimmelTick" value="0" @if(old('schimmelTick') ==  '0') checked @endif>

                                </div>
                                @error('schimmelTick')
                                <p class="help is-danger">{{ $message }}</p>
                                @enderror
                            </td>
                            <td>
                                <div class="control ">
                                    <input class="input form-control" value="{{old('schimmelAang')}}" type="text" name="schimmelAang" id=" ">
                                </div>
                            </td>
                            <td>
                                <div class="control ">
                                    <input class="input form-control" value="{{old('schimmelHtKd')}}" type="text" name="schimmelHtKd" id="">
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>Waan Ja/Nee</td>

                            <td>
                                <div @error('waanTick') is-danger @enderror" >
                                <label for="waanTick" class="has-text-success has-text-weight-bold" style = "font-size: 35px;">&check;</label>
                                <input type="radio" style = "width:40px; height:40px" id="" name="waanTick" value="1" @if(old('waanTick') ==  '1') checked @endif>
                                <label for="waanTick" class="has-text-danger has-text-weight-bold" style = "font-size: 35px;">&cross;</label>
                                <input type="radio" style = "width:40px; height:40px" id="" name="waanTick" value="0" @if(old('waanTick') ==  '0') checked @endif>

                                </div>
                                @error('waanTick')
                                <p class="help is-danger">{{ $message }}</p>
                                @enderror
                            </td>
                            <td>
                                <div class="control ">
                                    <input class="input form-control" value="{{old('waanAang')}}" type="text" name="waanAang" id=" ">
                                </div>
                            </td>
                            <td>
                                <div class="control ">
                                    <input class="input form-control" value="{{old('waanHtKd')}}" type="text" name="waanHtKd" id="">
                                </div>
                            </td>
                        </tr>
                    </table>
                </section>


                <section class="section">
                    <section class="hero">
                        <div class="hero-body">
                            <h5 class="card bg-gradient-purple">Klossen</h5>
                        </div>
                        <p class="card bg-gradient-red subtitle form-control">Select only one </p>
                    </section>

                    <table class="table table-bordered table-hover table-secondary">
                        <tr>
                            <th></th>
                            <th>Type</th>
                            <th>Aangepast naar</th>
                            <th>Ht/Kd: vocht %</th>
                        </tr>

                        <tr>
                            <td>Soort</td>
                            <td>
                                <div>
                                    <div class="control">
                                        <select name="soort" class="textarea custom-select  @error ('soort') is-danger @enderror ">
                                            <option value="">Choose Type</option>
                                            <option value='Spaan' @if(old('soort') ==  'Spaan') selected @endif>Spaan</option>
                                            <option value="Hout" @if(old('soort') ==  'Hout') selected @endif>Hout</option>
                                        </select>
                                    </div>
                                    @error('soort')
                                    <p class="help is-danger">{{ $message }}</p>
                                    @enderror

                                </div>
                            </td>

                            <td>
                                <div class="control ">
                                    <input class="input form-control" value="{{old('soortAang')}}" type="text" name="soortAang" id="" >
                                </div>
                            </td>

                            <td>
                                <div class="control ">
                                    <input class="input form-control" value="{{old('soortHtKd')}}" type="text" name="soortHtKd" id="">
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>Balk</td>

                            <td>
                                <div>
                                    <div class="control">
                                        <select name="balk" class="textarea custom-select   @error ('balk') is-danger @enderror ">
                                            <option value="">Choose Measurement</option>
                                            <option value="Afmeting1" @if(old('balk') ==  'Afmeting1') selected @endif>Afmeting 1</option>
                                            <option value="Afmeting2" @if(old('balk') ==  'Afmeting2') selected @endif>Afmeting 2</option>
                                        </select>
                                    </div>
                                    @error('balk')
                                    <p class="help is-danger">{{ $message }}</p>
                                    @enderror

                                </div>
                            </td>

                            <td>
                                <div class="control ">
                                    <input class="input form-control" value="{{old('balkAang')}}" type="text" name="balkAang" id="">
                                </div>
                            </td>

                            <td>

                                <div class="control ">
                                    <input class="input form-control" value="{{old('balkHtKd')}}" type="text" name="balkHtKd" id="" >
                                </div>
                            </td>
                        </tr>
                    </table>
                </section>


                <section class="section">
                    <section class="hero">
                        <div class="hero-body">
                            <h5 class="card bg-gradient-purple">Onderdek</h5>
                        </div>
                    </section>
                    <table class="table table-bordered table-hover table-secondary">
                        <tr>
                            <th></th>
                            <th>Type</th>
                            <th>Aangepast naar</th>
                            <th>Ht/Kd: vocht %</th>
                        </tr>

                        <tr>
                        <td> Description</td>
                            <td>
                                <div>
                                    <div class="control">
                                        <select name="onderdek" class="textarea custom-select  @error('onderdek') is-danger @enderror">
                                            <option value="">Choose Type</option>
                                            <option value='Brug' @if(old('onderdek') ==  'Brug') selected @endif>Brug</option>
                                            <option value="Ronddloper Afm(2x)" @if(old('onderdek') ==  'Ronddloper Afm(2x)') selected @endif>Ronddloper Afm(2x)</option>
                                            <option value="Ronddloper Afm(3x)" @if(old('onderdek') ==  'Ronddloper Afm(3x)') selected @endif>Ronddloper Afm(3x)</option>
                                            <option value="Kruisdek" @if(old('onderdek') ==  'Kruisdek') selected @endif>Kruisdek</option>
                                            <option value="Elementen" @if(old('onderdek') ==  'Elementen') selected @endif>Elementen</option>
                                            <option value="Dubbel Dek" @if(old('onderdek') ==  'Dubbel Dek') selected @endif>Dubbel Dek</option>
                                        </select>
                                    </div>
                                    @error('onderdek')
                                    <p class="help is-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </td>

                            <td>
                                <div class="control ">
                                    <input class="input form-control" value="{{old('onderdekAang')}}" type="text" name="onderdekAang" id="" >
                                </div>
                            </td>

                            <td>
                                <div class="control ">
                                    <input class="input form-control" value="{{old('onderdekHtKd')}}" type="text" name="onderdekHtKd" id="">

                                </div>
                            </td>
                        </tr>

                    </table>
                </section>


                <section class="section">
                    <section class="hero">
                        <div class="hero-body">
                            <h5 class="card bg-gradient-purple">Overvig</h5>
                        </div>
                    </section>

                    <table class="table table-bordered table-hover table-secondary">
                        <tr>
                            <th></th>
                            <th>Condition</th>
                            <th>Note</th>
                        </tr>

                        <tr>
                            <td>Hoeken zaag</td>

                            <td>
                                <div @error('hoekenTick') is-danger @enderror" >
                                <label for="hoekenTick" class="has-text-success has-text-weight-bold" style = "font-size: 35px;">&check;</label>
                                <input type="radio" style = "width:40px; height:40px" id="" name="hoekenTick" value="1" @if(old('hoekenTick') ==  '1') checked @endif>
                                <label for="hoekenTick" class="has-text-danger has-text-weight-bold" style = "font-size: 35px;">&cross;</label>
                                <input type="radio" style = "width:40px; height:40px" id="" name="hoekenTick" value="0" @if(old('hoekenTick') ==  '0') checked @endif>

                                </div>
                                @error('hoekenTick')
                                <p class="help is-danger">{{ $message }}</p>
                                @enderror
                            </td>
                            <td>
                                <div class="control ">
                                    <input class="input form-control" value="{{old('hoekenAang')}}" type="text" name="hoekenAang" id="" >
                                </div>
                            </td>

                        </tr>
                        <tr>
                            <td>Extra Stempels</td>
                            <td>
                                <div @error('stempelsTick') is-danger @enderror" >
                                <label for="stempelsTick" class="has-text-success has-text-weight-bold" style = "font-size: 35px;">&check;</label>
                                <input type="radio" style = "width:40px; height:40px" id="" name="stempelsTick" value="1" @if(old('stempelsTick') ==  '1') checked @endif>
                                <label for="stempelsTick" class="has-text-danger has-text-weight-bold" style = "font-size: 35px;">&cross;</label>
                                <input type="radio" style = "width:40px; height:40px" id="" name="stempelsTick" value="0" @if(old('stempelsTick') ==  '0') checked @endif>

                                </div>
                                @error('stempelsTick')
                                <p class="help is-danger">{{ $message }}</p>
                                @enderror
                            </td>

                            <td>
                                <div class="control ">
                                    <input class="input form-control" value="{{old('stempelsAang')}}" type="text" name="stempelsAang" id="" >
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>Stapel hoogte St/M</td>

                            <td>
                                <div @error('stapelTick') is-danger @enderror" >
                                <label for="stapelTick" class="has-text-success has-text-weight-bold" style = "font-size: 35px;">&check;</label>
                                <input type="radio" style = "width:40px; height:40px" id="" name="stapelTick" value="1" @if(old('stapelTick') ==  '1') checked @endif>
                                <label for="stapelTick" class="has-text-danger has-text-weight-bold" style = "font-size: 35px;">&cross;</label>
                                <input type="radio" style = "width:40px; height:40px" id="" name="stapelTick" value="0" @if(old('stapelTick') ==  '0') checked @endif>

                                </div>
                                @error('stapelTick')
                                <p class="help is-danger">{{ $message }}</p>
                                @enderror
                            </td>
                            <td>
                                <div class="control ">
                                    <input class="input form-control" value="{{old('stapelAang')}}" type="text" name="stapelAang" id=" ">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Strappen/ Markeren</td>
                            <td>
                                <div >
                                    <div class="control">
                                        <select name="strappenTick" class="textarea custom-select  @error('strappenTick') is-danger @enderror">
                                            <option value="">Choose Type</option>
                                            <option value='Strappen' @if(old('strappenTick') ==  'Strappen') selected @endif>Strappen</option>
                                            <option value="Markeren" @if(old('strappenTick') ==  'Markeren') selected @endif>Markeren</option>
                                        </select>
                                    </div>
                                    @error('strappenTick')
                                    <p class="help is-danger">{{ $message }}</p>
                                    @enderror

                                </div>
                            </td>

                            <td>
                                <div class="control ">
                                    <input class="input form-control" value="{{old('strappenAang')}}" type="text" name="strappenAang" id=" ">
                                </div>
                            </td>


                        </tr>

                        <tr>
                            <td>Q(kamer)/Loods/A</td>

                            <td>
                                <div >
                                    <div class="control">
                                        <select name="kamerTick" class="textarea custom-select  @error('kamerTick') is-danger @enderror">
                                            <option value="">Choose Type</option>
                                            <option value='Q(kamer)' @if(old('kamerTick') ==  'Q(kamer)') selected @endif >Q(kamer)</option>
                                            <option value="Loods" @if(old('kamerTick') ==  'Loods') selected @endif>Loods</option>
                                            <option value="A" @if(old('kamerTick') ==  'A') selected @endif>A</option>
                                        </select>
                                    </div>
                                    @error('kamerTick')
                                    <p class="help is-danger">{{ $message }}</p>
                                    @enderror

                                </div>
                            </td>
                            <td>
                                <div class="control ">
                                    <input class="input form-control" value="{{old('kamerAang')}}" type="text" name="kamerAang" id=" ">
                                </div>
                            </td>
                        </tr>
                    </table>
                </section>

                <section class="section">
                    <label class='' for='additionalNotes'>Additional Notes:</label>
                    <div class="control ">
                        <input class="table table-bordered table-hover table-secondary" value="{{old('additionalNotes')}}" type="text" name="additionalNotes" id="" placeholder="Optional comments">
                    </div>
                </section>

                <section class="section">
                        <section class="section">
                            <div>
                                <button type="submit" class="btn btn-info btn-lg btn-lg btn-block" id="submitNew">Save</button>
                            </div>
                            <div class="float-left">
                                <button type="reset" class="btn btn-warning btn-lg">Reset</button>
                                <a type="button" href="/home" class="btn btn-light btn-lg">Cancel</a>
                            </div>
                        </section>
                </section>
            </section>
        </form>
    </section>
    <script src="/js/disable.js"></script>
@endsection
