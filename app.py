from flask import Flask, render_template, request, jsonify
import os
import json
import xml_converter_to_add_annotation as xmlconv

app = Flask(__name__, static_url_path='/static')

# Set the upload folder within the static/xml directory
UPLOAD_FOLDER = "static/xml"
app.config['UPLOAD_FOLDER'] = UPLOAD_FOLDER

@app.route('/')
def index():
    return render_template('index.php')


@app.route('/my-flask-endpoint', methods=['POST'])
def my_flask_endpoint():
    counts = request.json['counts']
    arrow_states = request.json['arrowStates']
    # Perform some processing with counts and arrow_states
    print(counts,arrow_states)
    
    result = {'message': 'Processing successful!'}
    return jsonify(result)

@app.route('/upload', methods=['POST'])
def upload_file():
    if 'file' not in request.files:
        return 'No file part'

    file = request.files['file']
    print(file)
    if file.filename == '':
        return 'No selected file'

    file_extension = file.filename.split('.')[-1].lower()
    if file_extension != 'musicxml':
        return 'Invalid file format. Please upload a .musicxml file.'
    # Create the UPLOAD_FOLDER if it doesn't exist
    os.makedirs(app.config['UPLOAD_FOLDER'], exist_ok=True)

    # Save the file to the static/uploads folder
    file.save(os.path.join(app.config['UPLOAD_FOLDER'], file.filename))

    xmlconv.xmlConverterToAnnotation(os.path.join(app.config['UPLOAD_FOLDER'] + "/" + file.filename))
    return 'File uploaded successfully'

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5000, debug=True)