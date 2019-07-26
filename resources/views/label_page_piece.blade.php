<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <body>



    <div class="container">
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if (session('failure'))
    <div class="alert alert-danger">
        {{ session('failure') }}
    </div>
@endif

    <div class = "container">
        
    </div>

    <form action = "/events/page_piece/{!! $page_piece->id !!}/{!! $author !!}" method="post">
    @csrf
  <div class="form-group">
    <label for="exampleFormControlInput1">Location</label>
    <input type="text" class="form-control" id="location" name="location">
  </div>
  <div class="form-group">
    <label for="exampleFormControlInput1">Happening at:</label>
    <input type="text" class="form-control" id="happening_at" name="happening_at">
  </div>
  <div class="form-group">
    <label for="exampleFormControlInput1">Published at:</label>
    <input type="text" class="form-control" id="published_at" name="published_at">
  </div>
  <div class="form-group">
    <label for="exampleFormControlInput1">Person 1: </label>
    <input type="text" class="form-control" id="person1" name="people[0]">
  </div>
  <div class="form-group">
    <label for="exampleFormControlInput1">Person 2: </label>
    <input type="text" class="form-control" id="person2" name="people[1]">
  </div>
  <div class="form-group">
    <label for="exampleFormControlInput1">Person 3: </label>
    <input type="text" class="form-control" id="person3" name="people[2]">
  </div>
  <div class="form-group">
    <label for="exampleFormControlSelect2">Event Type:</label>
    <select multiple class="form-control" id="exampleFormControlSelect2", name="type">
      <option>telephone</option>
      <option>meeting</option>
      <option>announcement</option>
    </select>
  </div>

  <button type="submit" class="btn btn-primary">Submit</button>
    </form>

</div>

    <div class="container" id ="page_piece">
            {!! $page_piece->html !!}
    </div>


    <script>

    inputs = document.getElementsByTagName("input");

    inputIds = [];

        for(i = 0; i < inputs.length; i++)
        {
            inputIds.push(inputs[i].attributes.id);
        }

        function get_selection() {
            var txt = '';
            if (window.getSelection) {
                txt = window.getSelection();
            } else if (document.getSelection) {
                txt = document.getSelection();
            } else if (document.selection) {
                txt = document.selection.createRange().text;
            }

            for(i = 0; i < inputIds.length; i++)
            {
                if(inputIds[i] === undefined || inputIds[i] === 'is_no_event')
                {
                    continue;
                }

                inputValue = document.getElementById(inputIds[i].value);
                
                if(inputValue.value === '')
                {
                    inputValue.value = txt.toString();
                    if(inputIds[i].value)
                    break;
                }
            }
    }

    document.getElementById("page_piece").onclick = get_selection;
    </script>
            
    </body>
</html>
