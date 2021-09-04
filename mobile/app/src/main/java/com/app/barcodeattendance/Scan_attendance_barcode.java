package com.app.barcodeattendance;

import androidx.annotation.Nullable;
import androidx.appcompat.app.AppCompatActivity;

import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.TextView;
import android.widget.Toast;

import com.android.volley.AuthFailureError;
import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.google.zxing.integration.android.IntentIntegrator;
import com.google.zxing.integration.android.IntentResult;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.HashMap;
import java.util.Map;

public class Scan_attendance_barcode extends AppCompatActivity {

    public Func func;

    public String response,attendance_id;
    public TextView fname,level,course_code,dept,start_date,end_date;

    public Button scan;


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_scan_attendace_barcode);

        func = new Func(this);

        Bundle bundle = getIntent().getExtras();

         attendance_id = bundle.getString("view_id","empty");
        this.setTitle("Mark Attendance");

        if (attendance_id.equals("empty")){
            Intent intent = new Intent(getApplicationContext(), Main.class);
            startActivity(intent);
            return;
        }

        SharedPreferences sharedPreferences = getSharedPreferences("attendance", Context.MODE_PRIVATE);
        response = sharedPreferences.getString("attendance",null);

        fname = findViewById(R.id.staff_name);
        course_code = findViewById(R.id.course_code);
        dept = findViewById(R.id.dept);
        start_date = findViewById(R.id.start_date);
        level = findViewById(R.id.level);
        end_date = findViewById(R.id.end_date);

        scan = findViewById(R.id.scan);

        scan.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                IntentIntegrator intentIntegrator = new IntentIntegrator(Scan_attendance_barcode.this);
                intentIntegrator.setPrompt("Scan a barcode or QR Code");
                intentIntegrator.setOrientationLocked(true);
                intentIntegrator.initiateScan();
            }
        });

        String id;

        try {

            JSONObject object = new JSONObject(response);
            JSONArray data = object.getJSONArray("attendance");

            for (int i =0; i < data.length(); i++){
                JSONObject attendance_data = data.getJSONObject(i);

                id = attendance_data.getString("id");

                if (attendance_id.equals(id)){

                    fname.setText(attendance_data.getString("fname"));
                    course_code.setText(attendance_data.getString("title")+" ("+attendance_data.getString("code")+") ");
                    dept.setText(attendance_data.getString("name"));
                    start_date.setText(attendance_data.getString("start_time"));
                    end_date.setText(attendance_data.getString("end_time"));
                    level.setText(attendance_data.getString("level"));

                    break;
                }

            }

        }catch (JSONException e){
            e.printStackTrace();
        }

    }

    @Override
    protected void onActivityResult(int requestCode, int resultCode, @Nullable Intent data) {
        super.onActivityResult(requestCode, resultCode, data);

        IntentResult intentResult = IntentIntegrator.parseActivityResult(requestCode, resultCode, data);
        // if the intentResult is null then
        // toast a message as "cancelled"
        if (intentResult != null) {
            if (intentResult.getContents() == null) {
                func.error_toast("Cancelled");
            } else {
                // if the intentResult is not null we'll set
                // the content and format of scan message
                //func.success_toast(intentResult.getContents());

                String matric = intentResult.getContents();

                Scan_attendance(attendance_id,matric);
            }
        } else {
            super.onActivityResult(requestCode, resultCode, data);
        }
    }

    public void Scan_attendance(String attendance_id, String matric){

        func.startDialog();

        StringRequest request = new StringRequest(Request.Method.POST, Core.SITE_URL, new Response.Listener<String>() {
            @Override
            public void onResponse(String response) {

                func.dismissDialog();

                try {

                    JSONObject object = new JSONObject(response);
                    if (object.getString("error").equals("0")){
                        func.vibrate();
                        func.error_toast(object.getString("msg"));
                        return;
                    }

                    func.success_toast(object.getString("msg"));
                    Intent intent = new Intent(getApplicationContext(), Main.class);
                    startActivity(intent);

                }catch (JSONException e){
                    e.printStackTrace();
                }

            }
        }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                func.dismissDialog();
                func.error_toast(error.toString());
            }
        }){
            @Override
            protected Map<String, String> getParams() throws AuthFailureError {
                Map<String, String> param = new HashMap<>();
                param.put("action", "scan_barcode_attendance");
                param.put("matric", matric);
                param.put("attendance_id", attendance_id);
                return  param;
            }
        };

        RequestQueue queue = Volley.newRequestQueue(this);
        queue.add(request);

    }
}