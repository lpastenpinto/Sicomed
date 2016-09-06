package com.example.androidtablayout;

import android.app.TabActivity;
import android.content.Intent;
import android.os.Bundle;
import android.widget.TabHost;
import android.widget.TabHost.TabSpec;

public class TabLayout_Ficha_Clinica extends TabActivity {
    
	TabHost tabHost;
	TabSpec Datos_P;
	TabSpec Anam_P;
	TabSpec Anam_R;
	TabSpec examspec;
	TabSpec tratspec;
	TabSpec interspec;
	
    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.layout_tab);
        //tabs para meter todas las clases de la ficha clinica
        tabHost = getTabHost();
        Bundle bundle = this.getIntent().getExtras();
        // Tab para datospersonales
        Datos_P = tabHost.newTabSpec("Datos");
        Datos_P.setIndicator("Datos personales", getResources().getDrawable(R.drawable.icon_datos_tab));
        Intent Datos_Intent = new Intent(this, Datos_personales.class);               
        Datos_Intent.putExtras(bundle);
        Datos_P.setContent(Datos_Intent);
        
        //tab para anamnesis proxima
        Anam_P = tabHost.newTabSpec("Anam_p");        
        Anam_P.setIndicator("Anamnesis Proxima", getResources().getDrawable(R.drawable.icon_anamprox_tab));
        Intent AnamP_Intent = new Intent(this, Anamnesis_prox.class);
        AnamP_Intent.putExtras(bundle);
        Anam_P.setContent(AnamP_Intent);
        
        //tab para anamnesis remota
        Anam_R = tabHost.newTabSpec("Anam_r");
        Anam_R.setIndicator("Anamnesis Remota", getResources().getDrawable(R.drawable.icon_anamrem_tab));
        Intent AnamR_Intent = new Intent(this, Anamnesis_rem.class);
        AnamR_Intent.putExtras(bundle);
        Anam_R.setContent(AnamR_Intent);
        
        
        //tab para examenes
        examspec = tabHost.newTabSpec("Exam");
        examspec.setIndicator("Examenes", getResources().getDrawable(R.drawable.icon_exam_tab));
        Intent examIntent = new Intent(this, Examenes.class);
        examIntent.putExtras(bundle);
        examspec.setContent(examIntent);

        //tab para tratamiento
        tratspec = tabHost.newTabSpec("trat");
        tratspec.setIndicator("Tratamiento", getResources().getDrawable(R.drawable.icon_trat_tab));
        Intent tratIntent = new Intent(this, Tratamiento.class);
        tratIntent.putExtras(bundle);
        tratspec.setContent(tratIntent);

        
        //tab para interconsulta
        interspec = tabHost.newTabSpec("inter");
        interspec.setIndicator("Interconsultas", getResources().getDrawable(R.drawable.icon_inter_tab));
        Intent interIntent = new Intent(this, Interconsulta.class);
        interIntent.putExtras(bundle);
        interspec.setContent(interIntent);
       
        Agregar_Tabs();
        

    }
    
 public void Agregar_Tabs(){
	 
     // agregar todos los tabs al tab host
     tabHost.addTab(Datos_P); 
     tabHost.addTab(Anam_P); 
     tabHost.addTab(Anam_R); 
    tabHost.addTab(examspec);
     tabHost.addTab(tratspec);
     tabHost.addTab(interspec);	 
 }   
}