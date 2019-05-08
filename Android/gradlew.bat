package com.example.multiplications;

import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;
import android.view.ViewGroup;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Spinner;
import android.widget.ArrayAdapter;
import android.view.Gravity;
import java.io.BufferedReader;
import java.io.File;
import java.io.FileReader;
import java.io.IOException;
import java.util.Scanner;
import android.widget.AdapterView;
import android.widget.AdapterView.OnItemSelectedListener;
import android.widget.Toast;
import android.widget.ImageView;
import android.text.Editable;

public class MainActivity extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);
        wins=0;
        wrong=0;
        tries=1;
        directives=(TextView)findViewById(R.id.Directives);
        operationLabel=(TextView)findViewById(R.id.operationLabel);
        triesLabel=(TextView)findViewById(R.id.triesLabel) ;
        scoreLabel=(TextView)findViewById(R.id.scoreLabel) ;
        wrongLabel=(TextView) findViewById(R.id.wrong);
        numeros=(Spinner)findViewById(R.id.numeros);
        answer=(EditText)findViewById(R.id.answer);
        toastView = getLayoutInflater().inflate(R.layout.activity_toast_custom_view, (ViewGroup) findViewById(R.id.toastLayout));
        xreponse=findViewById(R.id.xreponse);
        instructions=findViewById(R.id.instruction);
        image= findViewById(R.id.imageView);

        try{
            operation = new Operation(9,'*');
        }
        catch(IllegalOperationException e){

        }
        operationLabel.setText(operation.getOperande2()+" X "+operation.getOperande1());




        ArrayAdapter<CharSequence> adapter = ArrayAdapter.createFromResource(this,
                R.array.numeros, android.R.layout.simple_spinner_item);

        adapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);

        numeros.setAdapter(adapter);

        numeros.setSelection(7);

        numeros.setOnItemSelectedListener(new OnItemSelected