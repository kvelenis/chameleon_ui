from music21 import converter, stream, instrument, note, meter
import music21

def generate_xml(sc, fileName="test_xml.xml", destination="/Users/maximoskaliakatsos-papakostas/Documents/python/miscResults/"):
    mf = music21.musicxml.m21ToXml.GeneralObjectExporter(sc)
    mfText = mf.parse().decode('utf-8')
    f = open(fileName, 'w')
    f.write(mfText.strip())
    f.close()