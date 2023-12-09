from music21 import converter, stream, instrument, note, meter
import music21
import generate_xml_midi as genxml

def xmlConverterToAnnotation(filename):
    # Load the MusicXML file
    original_score = converter.parse(filename)

    # Get Time Signature of the first measure, in later update find time signature changes
    first_part = original_score.parts[0]
    first_measure = first_part.getElementsByClass(stream.Measure)[0]
    time_signature = first_measure.getTimeSignatures()[0]

    # Get Time Signature Denominator of the first measure
    current_denominator = time_signature.denominator

    # Define a dictionary to map denominators to note types
    denominator_note_type = {
        2: "half",     # Half note
        4: "quarter",  # Quarter note
        8: "eighth",   # Eighth note
        16: "16th",    # 16th note
        }
    # Create a new instrument staff (Part) to add underneath the existing staff
    new_staff = stream.Part()
    flute_instrument = instrument.Flute()

    # Add the unpitched instrument to the new staff
    new_staff.append(flute_instrument)

    # Get the dominator type from dictionary
    current_denominator_type = denominator_note_type.get(current_denominator)


    # Iterate through the measures and beats and insert notes accordingly
    for measure in first_part.getElementsByClass(stream.Measure):
        for beat in range(int(time_signature.numerator)):
            newnote=note.Note("F5", type=current_denominator_type)
            newnote.style.color="#FF0000"
            new_staff.append(newnote)
            
            
    # Colorize the instrument (staff) in red
    new_staff.style.color = "#FF0000"
    new_staff.staffLines =1
    # Insert the new staff into the score
    original_score.insert(0, new_staff)

    # def generate_xml(sc, fileName="test_xml.xml", destination="/Users/maximoskaliakatsos-papakostas/Documents/python/miscResults/"):
    #     mf = music21.musicxml.m21ToXml.GeneralObjectExporter(sc)
    #     mfText = mf.parse().decode('utf-8')
    #     f = open(fileName, 'w')
    #     f.write(mfText.strip())
    #     f.close()
   

    genxml.generate_xml(original_score, filename.split(".")[0]+"_step2.musicxml", "/.")
    # Print the message "file_extracted"
    print("file_extracted")




