package com.app.barcodeattendance;

import android.content.DialogInterface;
import android.content.SharedPreferences;
import android.os.Build;
import android.os.Bundle;
import android.view.View;
import android.view.WindowManager;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ImageButton;

import androidx.appcompat.app.AppCompatActivity;

import com.android.volley.AuthFailureError;
import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.google.android.material.bottomsheet.BottomSheetDialog;
import com.google.android.material.floatingactionbutton.FloatingActionButton;

import org.json.JSONException;
import org.json.JSONObject;

import java.util.HashMap;
import java.util.Map;

public class Main extends AppCompatActivity {

    FloatingActionButton student;
    ImageButton home,change_password;
    private BottomSheetDialog mBottomSheetDialog,bottomSheetDialog;

    SharedPreferences sharedPreferences;
    public String response,student_id;

    Button submit_change_password;
    EditText npassword,password;

    public Func func;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        student = findViewById(R.id.student);
        home = findViewById(R.id.home);
        change_password = findViewById(R.id.change_password);

        func = new Func(this);

        sharedPreferences = getSharedPreferences("ALL_USER_INFO", MODE_PRIVATE);
        response = sharedPreferences.getString("all_user_info", null);

        try {

            JSONObject object = new JSONObject(response);
            JSONObject student_info = object.getJSONObject("student_info");
            student_id = student_info.getString("id");

        }catch (JSONException e){
            e.printStackTrace();
        }

        getSupportFragmentManager().beginTransaction().replace(R.id.container, new Dashboard()).addToBackStack(null).commit();

        student.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {

                func.startDialog();

                StringRequest request = new StringRequest(Request.Method.POST, Core.SITE_URL, new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {

                        func.dismissDialog();
                    }
                }, new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError error) {

                        func.dismissDialog();

                    }
                }){
                    @Override
                    protected Map<String, String> getParams() throws AuthFailureError {
                        Map<String, String> param = new HashMap<>();
                        param.put("action", "get_attendance");
                        param.put("student_id",student_id);
                        return  param;
                    }
                };

                RequestQueue queue = Volley.newRequestQueue(Main.this);
                queue.add(request);

            }
        });

        home.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                getSupportFragmentManager().beginTransaction().replace(R.id.container, new Dashboard()).addToBackStack(null).commit();
            }
        });

        change_password.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                bottomSheet();
            }
        });

    }

    @Override
    public void onBackPressed() {
        super.onBackPressed();
        getSupportFragmentManager().beginTransaction().replace(R.id.container, new Dashboard()).addToBackStack(null).commit();
    }


    public void bottomSheet(){

        final View view = getLayoutInflater().inflate(R.layout.bottomsheet, null);

        (view.findViewById(R.id.bt_close)).setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                mBottomSheetDialog.dismiss();
            }
        });

        mBottomSheetDialog = new BottomSheetDialog(this);
        mBottomSheetDialog.setContentView(view);
        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.LOLLIPOP) {
            mBottomSheetDialog.getWindow().addFlags(WindowManager.LayoutParams.FLAG_TRANSLUCENT_STATUS);
        }

        submit_change_password = view.findViewById(R.id.submit_change_password);

        npassword = view.findViewById(R.id.npassword);
        password = view.findViewById(R.id.password);

        submit_change_password.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {

                final String pass,npass;

                pass = password.getText().toString();
                npass = npassword.getText().toString();

                if (pass.isEmpty()){
                    func.vibrate();
                    func.error_toast("Old password is required");
                    return;
                }

                if (npass.isEmpty()){
                    func.vibrate();
                    func.error_toast("New password is required");
                    return;
                }

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

                            func.vibrate();
                            func.success_toast(object.getString("msg"));
                            mBottomSheetDialog.dismiss();

                        }catch (JSONException e){
                            e.printStackTrace();
                        }

                    }
                }, new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError error) {
                        func.vibrate();
                        func.error_toast("No internet connection, try again");
                        func.dismissDialog();
                    }
                }){
                    @Override
                    protected Map<String, String> getParams() throws AuthFailureError {
                        Map<String, String> param = new HashMap<>();
                        param.put("action", "change_password");
                        param.put("student_id",student_id);
                        param.put("password", pass);
                        param.put("npassword", npass);
                        return  param;
                    }
                };

                RequestQueue queue = Volley.newRequestQueue(Main.this);
                queue.add(request);

            }
        });

        mBottomSheetDialog.show();
        mBottomSheetDialog.setOnDismissListener(new DialogInterface.OnDismissListener() {
            @Override
            public void onDismiss(DialogInterface dialog) {
                mBottomSheetDialog = null;
            }
        });

    }
}
