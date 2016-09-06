package com.example.androidtablayout;

import java.io.IOException;
import java.net.HttpURLConnection;
import java.net.URL;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import android.app.Activity;
import android.app.AlertDialog;
import android.app.Dialog;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.os.Bundle;
import android.text.Layout;
import android.view.LayoutInflater;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.Window;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.Spinner;
import android.widget.TextView;
import android.widget.Toast;

public class Examenes extends Activity {
	
	private ImageView imageView;
    private Bitmap Imagen_Examen;
    Boolean Exist;
    String exm_comp;
    String[] nombres_examenes= {"Paciente Sin examenes"};
	static String txt_Escoger="Escoga examen..";
	static String HOST ="https://miguelost.cloudant.com/";
	static String DBNAME ="sicomed";
   // private PinchMapView imageView;
	 AlertDialog.Builder builder;
	 TextView Nombre_Ex;		
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.examenes_layout);                                
        builder = new AlertDialog.Builder(this);
        final TextView mnsaje_buscar = (TextView)findViewById(R.id.Lbltxt);
        final Spinner examen_elegir = (Spinner)findViewById(R.id.CmbOpciones);
        final TextView mnsaje_sel = (TextView)findViewById(R.id.LblMensaje);
        Nombre_Ex = (TextView)findViewById(R.id.LblMensaje1);
               
        final Button btn_comparar = (Button)findViewById(R.id.b_buscar);
        
        final Bundle bundle = this.getIntent().getExtras();        
        JSONObject Ficha_Clinica = FuncionesCouch.GetFichaClinica(HOST, DBNAME, bundle.getString("RUT"));
    	
        if(Ficha_Clinica.isNull("_attachments")){
	    /*builder.setTitle("Error");
	    builder.setMessage("null");
	    builder.setPositiveButton("OK",null);										    							                     		 
	    builder.create();
	    builder.show();*/
        	 btn_comparar.setEnabled(false);
        	 examen_elegir.setEnabled(false);
	    	Exist=false;
	    }else{
	    	
	    	Exist=true;
	        try {
				obtener_lista_examanes();
			} catch (JSONException e1) {
				// TODO Auto-generated catch block
				e1.printStackTrace();
			}
	    }
       
     
        //adaptador para almacenar la lista de los examenes
        ArrayAdapter<String> adaptador =
            new ArrayAdapter<String>(this,
                android.R.layout.simple_spinner_item, nombres_examenes);
        
        adaptador.setDropDownViewResource(
                android.R.layout.simple_spinner_dropdown_item);
        
        examen_elegir.setAdapter(adaptador);
        
        imageView = (ImageView) findViewById(R.id.image_view); 
        
 
        
        examen_elegir.setOnItemSelectedListener(
        	new AdapterView.OnItemSelectedListener() {
                public void onItemSelected(AdapterView<?> parent,
                    android.view.View v, int position, long id) {
                	if(Exist==true){
                		mostrar_examenes(position,bundle);
                	}
                }
         
                public void onNothingSelected(AdapterView<?> parent) {
                  
                }
        });
        
       
        btn_comparar.setOnClickListener(new OnClickListener() {
           
			public void onClick(View v) {
				comparar_examenes();
				
            }
        });
        
    }
    
    
void comparar_examenes(){
	

	final Bundle bundle = this.getIntent().getExtras(); 
	builder.setTitle("Escoga examen");
	builder.setItems(nombres_examenes, new DialogInterface.OnClickListener() {
	    public void onClick(DialogInterface dialog, int item) {
        	if(!nombres_examenes[item].equals(txt_Escoger)){
        		Nombre_Ex.setText("Examen: " + nombres_examenes[item]);
        	 
        		Toast.makeText(getApplicationContext(), nombres_examenes[item].toString(), Toast.LENGTH_SHORT).show();
        		
        		Intent intent = new Intent(Examenes.this, Layout_Comparar_Examenes.class);
            	
            	
            	//Creamos la informaci�n a pasar entre actividades
            	Bundle b = new Bundle(); 
           
            	b.putString("Ex_1", exm_comp);
            	
            	b.putString("Ex_2", nombres_examenes[item].toString());
            	b.putString("RUT",bundle.getString("RUT") );
            	//A�adimos la informaci�n al intent
            	intent.putExtras(b);
            	        	
            	//Iniciamos la nueva actividad
                startActivity(intent);

        	}				        
	    }
	});
	//se muestra el builder para elegir el otro examen
	builder.create();
	builder.show();

	
	
	
}
    
    
void mostrar_examenes(int position, Bundle bundle){
	if(!nombres_examenes[position].equals(txt_Escoger)){
		Nombre_Ex.setText("Examen: " + nombres_examenes[position]);
		exm_comp= nombres_examenes[position].toString();
		//asignacion a visor de imagen de examen de bd
		Imagen_Examen = FuncionesCouch.Get_Examen(HOST, DBNAME, bundle.getString("RUT"),  nombres_examenes[position]);                	
		imageView.setImageBitmap(Imagen_Examen);
	}
	
}
    
    
    
    
    
public void obtener_lista_examanes() throws JSONException{
	
	final Bundle bundle = this.getIntent().getExtras();        
    JSONObject Ficha_Clinica = FuncionesCouch.GetFichaClinica(HOST, DBNAME, bundle.getString("RUT"));
	
    JSONObject Attach = Ficha_Clinica.getJSONObject("_attachments");
	JSONArray names = Attach.names();
	nombres_examenes = new String[names.length()];
	for (int i = 0; i < names.length(); i++) {
		nombres_examenes[i] = names.getString(i);
		
		}
  

}
}
