package com.example.androidtablayout;

import java.util.Calendar;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import android.app.Activity;
import android.app.AlertDialog;
import android.os.Bundle;
import android.text.Editable;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;

public class Anamnesis_prox extends Activity {
	static String HOST ="https://miguelost.cloudant.com/";
	static String DBNAME ="sicomed";
	static TextView Hist_visit;
	static EditText Mot_edit;
	static EditText Prox_edit;
	
	
    public void onCreate(Bundle savedInstanceState) {
    	
        super.onCreate(savedInstanceState);
        setContentView(R.layout.anam_prox_layout);  
        final TextView Tit =(TextView)findViewById(R.id.txt);
        
        //asignacion a cada textview del id del layout
        Hist_visit =(TextView)findViewById(R.id.anam_prox_txt);
        
        final TextView T_1 =(TextView)findViewById(R.id.Mot_txt);  
        Mot_edit = (EditText)findViewById(R.id.Mot_edit);     
     
        final TextView Mot_2 =(TextView)findViewById(R.id.Anamprox_txt);
        Prox_edit = (EditText)findViewById(R.id.Anamprox_edit);

        final Button btn_guard = (Button)findViewById(R.id.b_edit);
        
        //obtener historial de las anamnesis proximas
        obtener_anam_prox();
        
                
        btn_guard.setOnClickListener(new OnClickListener() {
            public void onClick(View v) { 
            	
            	guardar_anam_prox();
            	
            }
        });
    }
    
   
    
    
    
    
    
    
 public void guardar_anam_prox(){
	 
	 //bundle para obtener el rut que se utilizo en la clase anterior
	 final Bundle bundle = this.getIntent().getExtras();
	 String rut = bundle.getString("RUT");
	 JSONObject Ficha_Clinica = FuncionesCouch.GetFichaClinica(HOST, DBNAME, rut);
 	 String fecha = null;
 	 String motivo = null;
 	 String anam_prox = null;
 	 Calendar fecha_Actual = Calendar.getInstance();   	
	 
	JSONArray json_array;
	
	//hacer siempre y cuando los valores no esten en blancos
	if(!Mot_edit.getText().toString().equals("")&&!Prox_edit.getText().toString().equals("")){
			try {
					//Obtener objeto "motivo_consulta " del json de la BD 
					json_array = Ficha_Clinica.getJSONArray("motivo_consulta");
					//creacion nuevo json para guardar anamnesis 
					JSONObject json = new JSONObject();
					//obtener fecha actual e insertar valores en json
					json.put("fecha",fecha_Actual.get(Calendar.DATE)+"/"+fecha_Actual.get(Calendar.MONTH)+"/"+fecha_Actual.get(Calendar.YEAR) );
					json.put("motivo", Mot_edit.getText());
					json.put("anam_prox", Prox_edit.getText());
					//ingresar nuevo json a jsonarray motivo_consulta
					json_array.put(json);
					
					//guardar nuevo anamnesis en base de datos
					FuncionesCouch.ActualizarFicha(HOST, DBNAME, Ficha_Clinica);
			 
					Toast toast=
					Toast.makeText(getApplicationContext(),
							"Se agrego Amnesis Proxima con Exito", Toast.LENGTH_SHORT);

					toast.show();
					String	nuevo_anam="Fecha:\n"+fecha_Actual.get(Calendar.DATE)+"/"+fecha_Actual.get(Calendar.MONTH)+"/"+fecha_Actual.get(Calendar.YEAR) +"\nMotivo de Consulta:\n"+Mot_edit.getText()+"\nAnamnesis Proxima:\n"+Prox_edit.getText()+"\n\n\n\n\n";
				 
					Hist_visit.setText(nuevo_anam+Hist_visit.getText());
			
			
					Mot_edit.setText("");
					Prox_edit.setText("");
			} catch (Exception e) {
				// TODO Auto-generated catch block
					AlertDialog.Builder error_0 = new AlertDialog.Builder(this);
					e.printStackTrace();
					error_0.setTitle("Error");
					error_0.setMessage("Imposible guardar Anamnesis proxima del paciente.\nCompruebe conexion a Internet");
					error_0.setPositiveButton("OK",null);										    							                     		 
					error_0.create();
					error_0.show();
			}
	}else{
		
		
		
				AlertDialog.Builder malo = new AlertDialog.Builder(this);
				//	e.printStackTrace();
				malo.setTitle("Campos Vacios");
				malo.setMessage("Compruebe que ambos campos esten llenos correctamente. Intente de nuevo");
				malo.setPositiveButton("OK",null);										    							                     		 
				malo.create();
				malo.show();
	}
	 
 } 
 
 
 
 
 
 
 
 
 
 
 
 
 
 public void obtener_anam_prox(){
	 final Bundle bundle = this.getIntent().getExtras();
	 String rut = bundle.getString("RUT");
	 
	 //Obtener ficha clinica de paciente
	 JSONObject Ficha_Clinica = FuncionesCouch.GetFichaClinica(HOST, DBNAME, rut);
 	 String fecha = null;
 	 String motivo = null;
 	 String anam_prox = null;
 	 try {
 
 		JSONArray the_json_array = Ficha_Clinica.getJSONArray("motivo_consulta");
 		
 		int a =the_json_array.length();
 		String text_Mot ="";
 		//recorrer el jsonarray motivo_consulta, de atras hacia adelante
 		for (int i = a-1; i >= 0; i--) {
 			
 	        JSONObject jsonObject = the_json_array.getJSONObject(i);
 	        fecha = jsonObject.getString("fecha");
 	        
 	        motivo = jsonObject.getString("motivo");
 	        anam_prox = jsonObject.getString("anam_prox");
 	        text_Mot=text_Mot+"Fecha:\n"+fecha+"\nMotivo de Consulta:\n"+motivo+"\nAnamnesis Proxima:\n"+anam_prox+"\n\n\n\n\n";
 
 		}
 		Hist_visit.setText(text_Mot);
			
		} catch (JSONException e1) {
			// TODO Auto-generated catch block
			e1.printStackTrace();
			AlertDialog.Builder error_1 = new AlertDialog.Builder(this);
			error_1.setTitle("Error");
		    error_1.setMessage("Imposible obtener Historial de Anamnesis proxima del paciente.\nCompruebe conexion a Internet");
		    error_1.setPositiveButton("OK",null);										    							                     		 
		    error_1.create();
		    error_1.show();
		}		 		 
 }   
}