package com.example.androidtablayout;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import android.app.Activity;
import android.app.AlertDialog;
import android.graphics.Color;
import android.os.Bundle;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;

public class Anamnesis_rem extends Activity {
	 

	 static String HOST ="https://miguelost.cloudant.com/";
	 static String DBNAME ="sicomed";
	 static EditText ant_morb_edit;
	 static EditText hab_edit;
	 static EditText med_edit;
	 static EditText ant_fam_edit;
	private EditText aler_med_edit;
	private EditText aler_alim_edit;
	private EditText aler_sustamb_edit;
	private EditText aler_sustpiel_edit;
	private EditText aler_picad_edit;
	
	 
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        //asignar nombre de layout 
        setContentView(R.layout.anam_rem_layout);
        
        //asignar ids a cada elemento del layout
        final TextView Tit =(TextView)findViewById(R.id.txt);
        
        final TextView ant_morb =(TextView)findViewById(R.id.antmorb_txt);
        ant_morb_edit = (EditText)findViewById(R.id.antmorb_edit);
        ant_morb_edit.setEnabled(false);
        ant_morb_edit.setBackgroundColor(Color.WHITE);
        ant_morb_edit.setTextColor(Color.BLACK);
        
        final TextView hab  =(TextView)findViewById(R.id.hab_txt);
        hab_edit = (EditText)findViewById(R.id.hab_edit);
        hab_edit.setEnabled(false);        
        hab_edit.setBackgroundColor(Color.WHITE);
        hab_edit.setTextColor(Color.BLACK);
             
        final TextView med =(TextView)findViewById(R.id.med_txt);
        med_edit = (EditText)findViewById(R.id.med_edit);
        med_edit.setEnabled(false);
        med_edit.setBackgroundColor(Color.WHITE);
        med_edit.setTextColor(Color.BLACK);
        
        final TextView ant_fam =(TextView)findViewById(R.id.antfam_txt);
        ant_fam_edit = (EditText)findViewById(R.id.antfam_edit);
        ant_fam_edit.setEnabled(false);
        ant_fam_edit.setBackgroundColor(Color.WHITE);
        ant_fam_edit.setTextColor(Color.BLACK);
        final TextView alergias =(TextView)findViewById(R.id.alergias_txt);
        
        final TextView a_med =(TextView)findViewById(R.id.aler_med_txt);
        aler_med_edit = (EditText)findViewById(R.id.aler_med_edit);
        aler_med_edit.setEnabled(false);
        aler_med_edit.setBackgroundColor(Color.WHITE);
        aler_med_edit.setTextColor(Color.BLACK);
        
        final TextView a_alim =(TextView)findViewById(R.id.aler_alim_txt);
        aler_alim_edit = (EditText)findViewById(R.id.aler_alim_edit);
        aler_alim_edit.setEnabled(false);
        aler_alim_edit.setBackgroundColor(Color.WHITE);
        aler_alim_edit.setTextColor(Color.BLACK);
        
        final TextView a_sust_amb =(TextView)findViewById(R.id.aler_sustamb_txt);
        aler_sustamb_edit = (EditText)findViewById(R.id.sustamb_edit);
        aler_sustamb_edit.setEnabled(false);
        aler_sustamb_edit.setBackgroundColor(Color.WHITE);
        aler_sustamb_edit.setTextColor(Color.BLACK);
        
        final TextView a_sustpiel =(TextView)findViewById(R.id.aler_sustpiel_txt);
        aler_sustpiel_edit = (EditText)findViewById(R.id.sustpiel_edit);
        aler_sustpiel_edit.setEnabled(false);
        aler_sustpiel_edit.setBackgroundColor(Color.WHITE);
        aler_sustpiel_edit.setTextColor(Color.BLACK);
        
        final TextView a_pica =(TextView)findViewById(R.id.picad_txt);
        aler_picad_edit = (EditText)findViewById(R.id.picad_edit);
        aler_picad_edit.setEnabled(false);
        aler_picad_edit.setBackgroundColor(Color.WHITE);
        aler_picad_edit.setTextColor(Color.BLACK);
        
        //obtener anamnesis remota
        obtener_anam_rem();
        
        final Button btn_edit = (Button)findViewById(R.id.b_edit);
       
        btn_edit.setOnClickListener(new OnClickListener() {
            public void onClick(View v) {
            	if(btn_edit.getText().equals("Editar"))
            	{	
					Toast toast=
							Toast.makeText(getApplicationContext(),
									"Lista para comenzar a editar", Toast.LENGTH_SHORT);
	 
					toast.show();
            	   	ant_morb_edit.setEnabled(true);
            	   	hab_edit.setEnabled(true);
            	   	med_edit.setEnabled(true);
            	   	ant_fam_edit.setEnabled(true);
            	    aler_med_edit.setEnabled(true);
            	   	aler_alim_edit.setEnabled(true);
            	   	aler_sustamb_edit.setEnabled(true);
            	   	aler_sustpiel_edit.setEnabled(true);
            	   	aler_picad_edit.setEnabled(true);
            		btn_edit.setText("Guardar");
            	}else{
            		
            		actualizar_anam_rem();
            	   	ant_morb_edit.setEnabled(false);
            	   	hab_edit.setEnabled(false);
            	   	med_edit.setEnabled(false);
            	   	ant_fam_edit.setEnabled(false);
            	    aler_med_edit.setEnabled(false);
            	   	aler_alim_edit.setEnabled(false);
            	   	aler_sustamb_edit.setEnabled(false);
            	   	aler_sustpiel_edit.setEnabled(false);
            	   	aler_picad_edit.setEnabled(false);
            		btn_edit.setText("Editar");
            		
            	}
            	
            }
        });
        
    }
    
    
    
    
    
    public void actualizar_anam_rem(){
    	//con bundle, obtener rut de paciente
      	 final Bundle bundle = this.getIntent().getExtras();
       	 String rut = bundle.getString("RUT");	
       	 
       	 try{
       	 JSONObject Ficha_Clinica = FuncionesCouch.GetFichaClinica(HOST, DBNAME, rut);
 		 //asignar a jsonobject los antecedentes
       	 JSONObject Antecedentes = Ficha_Clinica.getJSONObject("antecedentes");
 		 //asignar a un jsonsobject alergias, que estan en antecedentes
 		 JSONObject alergias = Antecedentes.getJSONObject("alergias");
       	 
 		//actualizar Antecedentes
 		 Antecedentes.put("ant_fam", ant_fam_edit.getText());
 		 Antecedentes.put("habitos", hab_edit.getText());
 		 Antecedentes.put("ant_morb", ant_morb_edit.getText());
 		Antecedentes.put("medicamentos", med_edit.getText());
 		
 		//actualziar alergias
 			alergias.put("sust_piel",aler_sustpiel_edit.getText());
 			alergias.put("alimentos", aler_alim_edit.getText());
 			alergias.put("picaduras",aler_picad_edit.getText());
 			alergias.put("medicamentos", aler_med_edit.getText());
 			alergias.put("sust_amb", aler_sustamb_edit.getText());
 			FuncionesCouch.ActualizarFicha(HOST, DBNAME, Ficha_Clinica);
			Toast toast=
					Toast.makeText(getApplicationContext(),
							"Actualizacion exitosa", Toast.LENGTH_SHORT);

			toast.show();
       	 }catch(JSONException e) {
    			// TODO Auto-generated catch block
       		AlertDialog.Builder error_0 = new AlertDialog.Builder(this);
       		 	error_0.setTitle("Error ");
       		 	error_0.setMessage("Imposible actualizar Anamnesis Remota.\nCompruebe conexion a Internet");
       		 	error_0.setPositiveButton("OK",null);										    							                     		 
       		 	error_0.create();
       		 	error_0.show();
    			e.printStackTrace();

    		}
    	}
       	 
    	
    	
    	
    	
    	
    	
    	
    
    public void obtener_anam_rem(){
   	 final Bundle bundle = this.getIntent().getExtras();
   	 String rut = bundle.getString("RUT");	
   	 JSONObject Ficha_Clinica = FuncionesCouch.GetFichaClinica(HOST, DBNAME, rut);
    	 try {
    
    		 JSONObject Antecedentes = Ficha_Clinica.getJSONObject("antecedentes");
    		//visualizar anamnesis remota
    	       
    	        ant_morb_edit.setText(Antecedentes.getString("ant_morb"));
    	        hab_edit.setText(Antecedentes.getString("habitos"));
    	        med_edit.setText(Antecedentes.getString("medicamentos"));
    	        ant_fam_edit.setText(Antecedentes.getString("ant_fam")); 
    	      
    	        JSONObject jsonObject = Antecedentes.getJSONObject("alergias");

        		//visualizar alergias
        		        		        			        	        
        	        aler_med_edit.setText(jsonObject.getString("medicamentos"));
        	    	aler_alim_edit.setText(jsonObject.getString("alimentos"));
        	    	aler_sustamb_edit.setText(jsonObject.getString("sust_amb"));
        	    	aler_sustpiel_edit.setText(jsonObject.getString("sust_piel"));
        	    	aler_picad_edit.setText(jsonObject.getString("picaduras"));        	        	        	                	            	    		   			
   		} catch (JSONException e1) {
   			// TODO Auto-generated catch block
   			e1.printStackTrace();
   			AlertDialog.Builder error_1 = new AlertDialog.Builder(this);
   			error_1.setTitle("Error");
		    error_1.setMessage("Imposible obtener Anamnesis remota del paciente.\nCompruebe conexion a Internet");
		    error_1.setPositiveButton("OK",null);										    							                     		 
		    error_1.create();
		    error_1.show();
   		}   		    	   	    	
    }   
   }