package com.example.androidtablayout;

import java.util.Calendar;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import android.app.Activity;
import android.app.AlertDialog;
import android.os.Bundle;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Spinner;
import android.widget.TextView;
import android.widget.Toast;

public class Tratamiento extends Activity {
	static String HOST ="https://miguelost.cloudant.com/";
	static String DBNAME ="sicomed";
	static TextView Hist_Trat;
	static EditText Trat_edit;
	static EditText Control_edit;
	String[] fechas_trat;
	String fecha_tratamiento;
	static String txt_Escoger="Escoja fecha Tratamiento";
	Spinner fecha_trat_elegir;
	 
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.trat_layout);  
        
        //asignacion ids a elementos del layout
        final TextView Tit =(TextView)findViewById(R.id.txt);
        
        Hist_Trat =(TextView)findViewById(R.id.Hist_trat_txt);
        
        final TextView T_1 =(TextView)findViewById(R.id.Trat_txt);  
        Trat_edit = (EditText)findViewById(R.id.Trat_edit);     
     
        final Button btn_guard_trat = (Button)findViewById(R.id.b_guard_trat);
        
        final TextView Mot_2 =(TextView)findViewById(R.id.Control_txt);
        Control_edit = (EditText)findViewById(R.id.Control_edit);
       
        fecha_trat_elegir = (Spinner)findViewById(R.id.fecha_t);
        
        final Button btn_guard_control = (Button)findViewById(R.id.b_guard_control);
        
        
        btn_guard_control.setEnabled(false);
        Control_edit.setEnabled(false);
        
       try {
    	   //obtener las fechas para visualizarlas
		obtener_fechas_tratamientos();
	} catch (JSONException e) {
		// TODO Auto-generated catch block
		e.printStackTrace();
		AlertDialog.Builder error_0 = new AlertDialog.Builder(this); 
		error_0.setTitle("Error Conexion BD");
	    error_0.setMessage("Imposible obtener fechas de tratamientos.\nCompruebe conexion a Internet");
	    error_0.setPositiveButton("OK",null);										    							                     		 
	    error_0.create();
	    error_0.show();
	}
       //adaptador para listas de fechas
        ArrayAdapter<String> adaptador =
            new ArrayAdapter<String>(this,
                android.R.layout.simple_spinner_item, fechas_trat);
        
        adaptador.setDropDownViewResource(
                android.R.layout.simple_spinner_dropdown_item);
        
        fecha_trat_elegir.setAdapter(adaptador);
                                        
        //obtener el historial de todos los tratamientos
        obtener_hist_trat();                                
        fecha_trat_elegir.setOnItemSelectedListener(
            	new AdapterView.OnItemSelectedListener() {
                    public void onItemSelected(AdapterView<?> parent,
                        android.view.View v, int position, long id) {
                    	if(!fechas_trat[position].equals(txt_Escoger)){
                    		fecha_tratamiento=fechas_trat[position];
                            btn_guard_control.setEnabled(true);
                            Control_edit.setEnabled(true);
                    		
                    	}else if(fechas_trat[position].equals(txt_Escoger)){
                    		
                            btn_guard_control.setEnabled(false);
                            Control_edit.setEnabled(false);
                    		
                    	}
                    }
             
                    public void onNothingSelected(AdapterView<?> parent) {
                      
                    }
            });
        
                        
        btn_guard_trat.setOnClickListener(new OnClickListener() {
            public void onClick(View v) { 
            	
            	guardar_nuevo_tratamiento();
            	
            }
        });
        
        btn_guard_control.setOnClickListener(new OnClickListener() {
            public void onClick(View v) { 
            	
            	guardar_control(fecha_tratamiento);
            	            
            }
        });
    }
    
   
    
    
    
    
 public void guardar_nuevo_tratamiento(){
	 
	 final Bundle bundle = this.getIntent().getExtras();
	 String rut = bundle.getString("RUT");
	 JSONObject Ficha_Clinica = FuncionesCouch.GetFichaClinica(HOST, DBNAME, rut);
 	 Calendar fecha_Actual = Calendar.getInstance();   	
	
 	 
		//insertar 
		JSONArray json_array;
		if(!Trat_edit.getText().toString().equals("")){
				try {
			
						json_array = Ficha_Clinica.getJSONArray("tratamiento");
						JSONObject json = new JSONObject();
						JSONArray jarray = new JSONArray();
						json.put("fecha",fecha_Actual.get(Calendar.DATE)+"/"+fecha_Actual.get(Calendar.MONTH)+"/"+fecha_Actual.get(Calendar.YEAR) );
						json.put("indicacion", Trat_edit.getText());
						json.put("control", jarray);
						json_array.put(json);
			
						FuncionesCouch.ActualizarFicha(HOST, DBNAME, Ficha_Clinica);
			
						Trat_edit.setText("");
						Toast toast=
								Toast.makeText(getApplicationContext(),
										"Nuevo tratamiento guardado con exito", Toast.LENGTH_SHORT);

						toast.show();
						  try {
								obtener_fechas_tratamientos();
							} catch (JSONException e) {
								// TODO Auto-generated catch block
								e.printStackTrace();
								AlertDialog.Builder error_0 = new AlertDialog.Builder(this); 
								error_0.setTitle("Error Conexion BD");
							    error_0.setMessage("Imposible obtener fechas de tratamientos.\nCompruebe conexion a Internet");
							    error_0.setPositiveButton("OK",null);										    							                     		 
							    error_0.create();
							    error_0.show();
							}
						obtener_hist_trat();
						
				        ArrayAdapter<String> adaptador =
				                new ArrayAdapter<String>(this,
				                    android.R.layout.simple_spinner_item, fechas_trat);
				            
				            adaptador.setDropDownViewResource(
				                    android.R.layout.simple_spinner_dropdown_item);
				            
				            fecha_trat_elegir.setAdapter(adaptador);
				            
			
				} catch (JSONException e) {
					// 	TODO Auto-generated catch block
						AlertDialog.Builder error_1 = new AlertDialog.Builder(this); 
						e.printStackTrace();
						error_1.setTitle("Error ");
						error_1.setMessage("Imposible guardar nuevo tratamiento.\nCompruebe conexion a Internet");
						error_1.setPositiveButton("OK",null);										    							                     		 
						error_1.create();
						error_1.show();
				}
		}else{
			AlertDialog.Builder error_11 = new AlertDialog.Builder(this); 
			//e.printStackTrace();
				error_11.setTitle("Campos vacios ");
				error_11.setMessage("El campo de Nuevo Tratamiento esta vacio. LLenelo y vuelva a guardar");
				error_11.setPositiveButton("OK",null);										    							                     		 
				error_11.create();
				error_11.show();
			
		}
	 
 } 
 
 
 
 
 
 
 
 
 
 
 
 
 
 public void obtener_fechas_tratamientos() throws JSONException{
		
		final Bundle bundle = this.getIntent().getExtras();        
	    JSONObject Ficha_Clinica = FuncionesCouch.GetFichaClinica(HOST, DBNAME, bundle.getString("RUT"));
	    JSONArray Tratamiento = Ficha_Clinica.getJSONArray("tratamiento");
 		//visualizar
 		int a =Tratamiento.length();
	    fechas_trat = new String[a+1];
	    fechas_trat[0]=txt_Escoger;
	    //	obtener fechas de atras hacia adelante
 		for (int i = a; i > 0; i--) {
 			
 	        JSONObject jsonObject_Trat = Tratamiento.getJSONObject(i-1);
 	        
            fechas_trat[i]=jsonObject_Trat.getString("fecha");
            }

	  }
 
 
 
 
 
 
 
 
 
 
 
 public void obtener_hist_trat(){
	 final Bundle bundle = this.getIntent().getExtras();
	 String rut = bundle.getString("RUT");
	 
	 JSONObject Ficha_Clinica = FuncionesCouch.GetFichaClinica(HOST, DBNAME, rut);
 	 
	 String fecha = null;
 	 String indicacion = null;
 	 
 	 String fecha_control = null;
 	String evol_control = null;
 	 try {
 
 		JSONArray Tratamiento = Ficha_Clinica.getJSONArray("tratamiento");
 		//visualizar
 		int a =Tratamiento.length();
 		String text_Trat ="";
 		for (int i = a-1; i >=0; i--) {
 			
 	        JSONObject jsonObject_Trat = Tratamiento.getJSONObject(i);
 	        
 	        fecha = jsonObject_Trat.getString("fecha");
 	        
 	        indicacion = jsonObject_Trat.getString("indicacion");
 	       
 	       JSONArray Control = jsonObject_Trat.getJSONArray("control");
 	           String ctrol_txt="";
 	           int s;
 	          //recorre el json array de controles 
 	       for (int x = 0; x < Control.length(); x++) {
 	    	   	JSONObject jsonObject_control = Control.getJSONObject(x);
 	    	   	fecha_control = jsonObject_control.getString("fecha");
 	    	   	evol_control = jsonObject_control.getString("evolucion");
 	    	   	s=x+1;
 	    	   	ctrol_txt=ctrol_txt+"\tFecha Control N"+ s + ": "+fecha_control + "\n\tControl y Evolucion:"+ evol_control+"\n\n";
 	       } 	         	         	    
 	             	        
 	        text_Trat=text_Trat+"Fecha Tratamiento:\n"+fecha+"\nIndicaciones:\n"+indicacion+"\nControl y Evolucion:\n"+ctrol_txt+"\n\n\n\n\n";
 
 		}
 		Hist_Trat.setText(text_Trat);
			
		} catch (JSONException e1) {
			// TODO Auto-generated catch block
			e1.printStackTrace();
			AlertDialog.Builder error_2 = new AlertDialog.Builder(this); 
			error_2.setTitle("Error Conexion BD");
		    error_2.setMessage("Imposible Obtener Historial de tratamientos.\nCompruebe conexion a Internet");
		    error_2.setPositiveButton("OK",null);										    							                     		 
		    error_2.create();
		    error_2.show();

		}
		
 	
	 
	 
 }   
 
 
 
 
 
 
 
 
 
 
 
 
 public void guardar_control(String fecha_examen){
	 
	 final Bundle bundle = this.getIntent().getExtras();
	 String rut = bundle.getString("RUT");
	 
	 JSONObject Ficha_Clinica = FuncionesCouch.GetFichaClinica(HOST, DBNAME, rut);
 	 
	 String fecha = null;
 	 Calendar fecha_Actual = Calendar.getInstance();  

 	 
 	 if(!Control_edit.getText().toString().equals("")){
 		 	try {
 
 		 		JSONArray Tratamiento = Ficha_Clinica.getJSONArray("tratamiento");
 		 		//visualizar
 		 		int a =Tratamiento.length();
 	
 		 		for (int i = 0; i < a; i++) {
 			
 		 			JSONObject jsonObject_Trat = Tratamiento.getJSONObject(i);
 		 			fecha = jsonObject_Trat.getString("fecha");
 	        
 		 			if(fecha.equals(fecha_examen)){
 		 					JSONArray Control = jsonObject_Trat.getJSONArray("control");
 		 					JSONObject json = new JSONObject();
 		 					json.put("fecha",fecha_Actual.get(Calendar.DATE)+"/"+fecha_Actual.get(Calendar.MONTH)+"/"+fecha_Actual.get(Calendar.YEAR) );
 				
 		 					json.put("evolucion", Control_edit.getText());
 				
 		 					Control.put(json);
 		 					FuncionesCouch.ActualizarFicha(HOST, DBNAME, Ficha_Clinica); 				
 		 			} 	        	        	       	       
 		 		}
 
 		 		Toast toast=
				Toast.makeText(getApplicationContext(),
						"Control de Tratamiento guardado con exito", Toast.LENGTH_SHORT);

 		 		toast.show();
 		 		obtener_hist_trat();
 		 	} catch (JSONException e1) {
 		 		// TODO Auto-generated catch block
 		 		e1.printStackTrace();
 		 		AlertDialog.Builder error_3 = new AlertDialog.Builder(this); 
 		 		error_3.setTitle("Error Conexion BD");
 		 		error_3.setMessage("Imposible guardar control de tratamiento.\nCompruebe conexion a Internet");
 		 		error_3.setPositiveButton("OK",null);										    							                     		 
 		 		error_3.create();
 		 		error_3.show();

		}
 	 }else{
	 			AlertDialog.Builder error_31 = new AlertDialog.Builder(this); 
		 		error_31.setTitle("Campos vacios");
		 		error_31.setMessage("El campo Contrl y Evolucion esta vacio. LLenelos de nuevo y vuelva a guardar");
		 		error_31.setPositiveButton("OK",null);										    							                     		 
		 		error_31.create();
		 		error_31.show();
 		 
 		 
 	 }
 	Control_edit.setText("");
	 	 
 }   
 
}