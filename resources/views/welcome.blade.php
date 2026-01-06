<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <title>OneDrive File Upload</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f4f6f8;
                display: flex;
                align-items: center;
                justify-content: center;
                height: 100vh;
                margin: 0;
            }

            .upload-container {
                background-color: white;
                padding: 2rem;
                border-radius: 8px;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
                width: 300px;
                text-align: center;
            }

            h2 {
                margin-bottom: 1.5rem;
                color: #333;
            }

            input[type="file"] {
                display: block;
                margin: 1rem auto;
            }

            button {
                background-color: #0078D4;
                color: white;
                border: none;
                padding: 0.6rem 1.2rem;
                border-radius: 4px;
                cursor: pointer;
                font-size: 1rem;
            }

            button:hover {
                background-color: #005ea6;
            }
        </style>
    </head>

    <body>
        @if ($errors->has('onedrive'))
            <div class="alert alert-danger">
                {{ $errors->first('onedrive') }}
            </div>
        @endif

        <div class="upload-container">
            <h2>Upload to OneDrive</h2>
            <form id="uploadForm" method="post" action="{{ route('store-file') }}" enctype="multipart/form-data">
                @csrf
                <input type="file" name="dokumen" required>
                <button type="submit">Upload</button>
                @if (session('message'))
                    <div style="padding-top: 10px">
                        {{ session('message') }}
                    </div>
                @endif
                <br>
                <div>
                    @if ($files->count() > 0)
                        <br>
                        <hr>
                        <h2>Uploaded files</h2>
                        @foreach ($files as $file)
                            <ul>
                                <li><a href="{{ $file->download_url }}">{{ $file->file_name }}</a></li>
                            </ul>
                        @endforeach
                    @endif
                </div>
            </form>
        </div>

    </body>

</html>
